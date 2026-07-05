<?php

namespace App\Models;

use CodeIgniter\Model;

class LeconModel extends Model
{
    protected $table      = 'lecons';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['module_id', 'titre', 'video_url', 'duree', 'type', 'is_free', 'position'];
    protected $useTimestamps = true;

    public function getByModule(int $moduleId): array
    {
        return $this->where('module_id', $moduleId)
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }

    public function nextPosition(int $moduleId): int
    {
        $row = $this->selectMax('position')->where('module_id', $moduleId)->first();
        return ($row['position'] ?? 0) + 1;
    }

    /** Retourne le total de minutes pour un module */
    public function totalDureeModule(int $moduleId): int
    {
        $row = $this->selectSum('duree')->where('module_id', $moduleId)->first();
        return (int)($row['duree'] ?? 0);
    }

    /** Retourne le total de minutes pour une formation (via modules) */
    public function totalDureeFormation(array $moduleIds): int
    {
        if (empty($moduleIds)) return 0;
        $row = $this->selectSum('duree')->whereIn('module_id', $moduleIds)->first();
        return (int)($row['duree'] ?? 0);
    }
}
