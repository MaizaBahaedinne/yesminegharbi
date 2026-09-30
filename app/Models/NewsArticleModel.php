<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsArticleModel extends Model
{
    protected $table         = 'news_articles';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['slug', 'titre', 'extrait', 'thumbnail', 'contenu', 'video_urls', 'statut', 'published_at'];
    protected $useTimestamps = true;

    public function published(): array
    {
        return $this->where('statut', 'publie')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->findAll();
    }

    public function bySlug(string $slug): ?array
    {
        $article = $this->where('slug', $slug)
            ->where('statut', 'publie')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->first();

        if ($article) {
            return $article;
        }

        foreach ($this->published() as $candidate) {
            if (self::routeSlug((string) $candidate['slug']) === self::routeSlug($slug)) {
                return $candidate;
            }
        }

        return null;
    }

    public static function routeSlug(string $value): string
    {
        if (function_exists('transliterator_transliterate')) {
            $transliterated = transliterator_transliterate('Any-Latin; Latin-ASCII', $value);
        } else {
            $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        }

        $transliterated = strtolower((string) ($transliterated ?: $value));

        return trim(preg_replace('/[^a-z0-9]+/', '-', $transliterated) ?? '', '-');
    }

    public static function facebookVideoUrls(?string $raw): array
    {
        $urls = [];
        foreach (preg_split('/\R/u', trim((string) $raw)) ?: [] as $url) {
            $url = trim($url);
            if ($url === '') {
                continue;
            }
            $parts = parse_url($url);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $path = (string) ($parts['path'] ?? '');
            $allowedHost = in_array($host, ['facebook.com', 'www.facebook.com', 'm.facebook.com', 'fb.watch'], true);
            $validPath = $host === 'fb.watch'
                ? preg_match('~^/[A-Za-z0-9_-]+/?$~', $path) === 1
                : preg_match('~^/(?:watch/?|reel/|share/[vr]/|[^/]+/videos/|video\.php$)~', $path) === 1;

            if (! $allowedHost || ! $validPath || ! in_array(strtolower((string) ($parts['scheme'] ?? 'https')), ['http', 'https'], true)) {
                return [];
            }

            $urls[] = $url;
        }

        return array_values(array_unique($urls));
    }

    public static function videoUrlsFromStored(?string $raw): array
    {
        $decoded = json_decode((string) $raw, true);
        return is_array($decoded) ? self::facebookVideoUrls(implode("\n", $decoded)) : self::facebookVideoUrls($raw);
    }

    public static function sanitizeContent(string $html): string
    {
        $allowed = ['p', 'br', 'h2', 'h3', 'h4', 'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'ul', 'ol', 'li', 'blockquote', 'a'];
        $document = new \DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $document->getElementsByTagName('div')->item(0);
        if (! $root) {
            return '';
        }

        $normalizeLists = static function (\DOMNode $parent) use (&$normalizeLists, $document): void {
            foreach (iterator_to_array($parent->childNodes) as $child) {
                if (! $child instanceof \DOMElement) {
                    continue;
                }
                $normalizeLists($child);
                if (strtolower($child->tagName) !== 'ol') {
                    continue;
                }

                $fragment = $document->createDocumentFragment();
                $list = null;
                $listType = null;
                foreach (iterator_to_array($child->childNodes) as $item) {
                    if (! $item instanceof \DOMElement || strtolower($item->tagName) !== 'li') {
                        $fragment->appendChild($item);
                        continue;
                    }

                    $type = $item->getAttribute('data-list') === 'bullet' ? 'ul' : 'ol';
                    if ($listType !== $type) {
                        $listType = $type;
                        $list = $document->createElement($type);
                        $fragment->appendChild($list);
                    }
                    $newItem = $document->createElement('li');
                    while ($item->firstChild) {
                        $newItem->appendChild($item->firstChild);
                    }
                    $list->appendChild($newItem);
                }

                $parent->replaceChild($fragment, $child);
            }
        };
        $normalizeLists($root);

        $clean = static function (\DOMNode $parent) use (&$clean, $allowed): void {
            for ($node = $parent->firstChild; $node !== null;) {
                $next = $node->nextSibling;
                if ($node instanceof \DOMElement) {
                    $tag = strtolower($node->tagName);
                    if (! in_array($tag, $allowed, true)) {
                        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math'], true)) {
                            $parent->removeChild($node);
                        } else {
                            while ($node->firstChild) {
                                $parent->insertBefore($node->firstChild, $node);
                            }
                            $parent->removeChild($node);
                        }
                    } else {
                        $href = $tag === 'a' ? trim((string) $node->getAttribute('href')) : '';
                        foreach (iterator_to_array($node->attributes) as $attribute) {
                            $node->removeAttributeNode($attribute);
                        }
                        if ($tag === 'a') {
                            if (filter_var($href, FILTER_VALIDATE_URL) && in_array(strtolower((string) parse_url($href, PHP_URL_SCHEME)), ['http', 'https'], true)) {
                                $node->setAttribute('href', $href);
                            } else {
                                $node->removeAttribute('href');
                            }
                            $node->setAttribute('rel', 'noopener noreferrer');
                        }
                        $clean($node);
                    }
                } elseif ($node->nodeType !== XML_TEXT_NODE) {
                    $parent->removeChild($node);
                }
                $node = $next;
            }
        };

        $clean($root);
        $result = '';
        foreach ($root->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        return trim($result);
    }
}
