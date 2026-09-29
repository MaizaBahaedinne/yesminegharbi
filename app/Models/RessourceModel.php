<?php

namespace App\Models;

use CodeIgniter\Model;

class RessourceModel extends Model
{
    public const TYPES = [
        'atelier'   => 'Atelier',
        'methode'   => 'Méthode',
        'guide'     => 'Guide',
        'template'  => 'Template',
        'checklist' => 'Checklist',
        'kit'       => 'Kit',
    ];

    public const THEMATIQUES = [
        'carriere'                => 'Carrière',
        'recherche-emploi'        => 'Recherche d’emploi',
        'cv-candidature'          => 'CV & Candidature',
        'linkedin-branding'       => 'LinkedIn & Personal Branding',
        'recrutement-rh'          => 'Recrutement & RH',
        'marque-employeur'        => 'Marque employeur',
        'apprentissage-formation' => 'Apprentissage & Formation',
        'ia-carriere'             => 'IA & Carrière',
    ];

    protected $table      = 'ressources';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'slug', 'titre', 'description_courte', 'description_longue',
        'type', 'profil', 'thematique', 'thematiques_secondaires',
        'prix', 'fichier_path', 'video_url', 'cover_image',
        'is_premium', 'tag_badge', 'sort_order',
        'view_count', 'download_count',
    ];
    protected $useTimestamps = true;

    public function getFree(int $limit = 0): array
    {
        $builder = $this->where('is_premium', 0)->orderBy('sort_order', 'ASC');
        return $limit > 0 ? $builder->findAll($limit) : $builder->findAll();
    }

    public function getPremium(int $limit = null, ?string $type = null, ?string $profil = null): array
    {
        $builder = $this->where('is_premium', 1)->orderBy('sort_order', 'ASC');

        if ($type && $type !== 'tous') {
            $builder->where('type', $type);
        }
        if ($profil && $profil !== 'tous') {
            $builder->where('profil', $profil);
        }

        return $limit > 0 ? $builder->findAll($limit) : $builder->findAll();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }

    public static function youtubeId(?string $url): ?string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }
        if (preg_match('~^[A-Za-z0-9_-]{11}$~', $url)) {
            return $url;
        }
        $pattern = '~^(?:https?://)?(?:www\.|m\.)?(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~i';

        return preg_match($pattern, $url, $m) ? $m[1] : null;
    }

    /** Absolute path of a resource file: private uploads (writable/) first, then legacy public files. */
    public static function resolveFilePath(?string $relative): ?string
    {
        $relative = ltrim(str_replace('\\', '/', (string) $relative), '/');
        if ($relative === '' || str_contains($relative, '..')) {
            return null;
        }
        foreach ([WRITEPATH, FCPATH] as $base) {
            if (is_file($base . $relative)) {
                return $base . $relative;
            }
        }

        return null;
    }

    public function incrementViewCount(int $id): void
    {
        $db = $this->db;
        if (! $db->fieldExists('view_count', $this->table)) {
            return;
        }

        $db->table($this->table)
            ->set('view_count', 'COALESCE(view_count, 0) + 1', false)
            ->where('id', $id)
            ->update();
    }

    public function incrementDownloadCount(int $id): void
    {
        $db = $this->db;
        if (! $db->fieldExists('download_count', $this->table)) {
            return;
        }

        $db->table($this->table)
            ->set('download_count', 'COALESCE(download_count, 0) + 1', false)
            ->where('id', $id)
            ->update();
    }
}
