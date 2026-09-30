<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsArticleModel extends Model
{
    protected $table         = 'news_articles';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['slug', 'titre', 'extrait', 'contenu', 'video_urls', 'statut', 'published_at'];
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
        return $this->where('slug', $slug)
            ->where('statut', 'publie')
            ->where('published_at <=', date('Y-m-d H:i:s'))
            ->first();
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
}
