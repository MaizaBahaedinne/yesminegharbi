<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnerModel extends Model
{
    protected $table         = 'partners';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nom', 'logo', 'instagram_url', 'position', 'is_active'];
    protected $useTimestamps = true;

    public function activePartners(): array
    {
        return $this->where('is_active', 1)->orderBy('position', 'ASC')->orderBy('nom', 'ASC')->findAll();
    }

    public static function instagramEmbedUrl(?string $url): ?string
    {
        $publicUrl = self::instagramPublicUrl($url);
        if ($publicUrl === null) {
            return null;
        }

        $parts = parse_url($publicUrl);
        $segments = explode('/', trim((string) ($parts['path'] ?? ''), '/'));

        return 'https://www.instagram.com/' . $segments[0] . '/' . $segments[1] . '/embed';
    }

    public static function instagramPublicUrl(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }

        $parts = parse_url($url);
        $host = strtolower((string) ($parts['host'] ?? ''));
        $path = trim((string) ($parts['path'] ?? ''), '/');
        $segments = explode('/', $path);
        $validHost = in_array($host, ['instagram.com', 'www.instagram.com'], true);

        if (! $validHost || count($segments) < 2 || ! in_array($segments[0], ['reel', 'reels', 'p', 'tv'], true)) {
            return null;
        }

        $code = $segments[1];
        if (! preg_match('/^[A-Za-z0-9_-]+$/', $code)) {
            return null;
        }

        $kind = $segments[0] === 'reels' ? 'reel' : $segments[0];

        return 'https://www.instagram.com/' . $kind . '/' . $code . '/';
    }
}
