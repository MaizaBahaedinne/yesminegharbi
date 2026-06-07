<?php

namespace App\Models;

use CodeIgniter\Model;

class RessourceModel extends Model
{
    protected $table      = 'ressources';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'slug', 'titre', 'description_courte', 'description_longue',
        'type', 'profil', 'prix', 'fichier_path', 'cover_image',
        'is_premium', 'tag_badge', 'sort_order',
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
}
