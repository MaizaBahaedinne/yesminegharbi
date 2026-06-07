<?php

namespace App\Models;

use CodeIgniter\Model;

class FormationModel extends Model
{
    protected $table      = 'formations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'slug', 'titre', 'description_courte', 'description_longue',
        'prix', 'niveau', 'theme', 'statut', 'modules_count', 'heures',
        'cover_image', 'is_populaire', 'sort_order',
    ];
    protected $useTimestamps = true;

    public function getAll(int $limit = 0): array
    {
        $builder = $this->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC');
        return $limit > 0 ? $builder->findAll($limit) : $builder->findAll();
    }

    public function getFiltered(?string $niveau, ?string $theme): array
    {
        $builder = $this->orderBy('sort_order', 'ASC');

        if ($niveau && $niveau !== 'tous') {
            $builder->where('niveau', $niveau);
        }
        if ($theme && $theme !== 'tous') {
            $builder->where('theme', $theme);
        }

        return $builder->findAll();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }

    public function getModules(int $formationId): array
    {
        return $this->db->table('modules')
            ->where('formation_id', $formationId)
            ->orderBy('position', 'ASC')
            ->get()
            ->getResultArray();
    }
}
