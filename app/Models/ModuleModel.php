<?php

namespace App\Models;

use CodeIgniter\Model;

class ModuleModel extends Model
{
    protected $table      = 'modules';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['formation_id', 'titre', 'description', 'position'];
    protected $useTimestamps = true;

    public function getByFormation(int $formationId): array
    {
        return $this->where('formation_id', $formationId)
                    ->orderBy('position', 'ASC')
                    ->findAll();
    }

    public function getWithLecons(int $formationId): array
    {
        $modules = $this->getByFormation($formationId);
        $leconModel = new LeconModel();
        foreach ($modules as &$module) {
            $module['lecons'] = $leconModel->getByModule($module['id']);
        }
        return $modules;
    }

    public function nextPosition(int $formationId): int
    {
        $row = $this->selectMax('position')->where('formation_id', $formationId)->first();
        return ($row['position'] ?? 0) + 1;
    }
}
