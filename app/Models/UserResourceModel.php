<?php

namespace App\Models;

use CodeIgniter\Model;

class UserResourceModel extends Model
{
    protected $table          = 'user_resources';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $allowedFields  = ['user_id', 'resource_id'];

    public function hasAccess(int $userId, int $resourceId): bool
    {
        return $this->where(['user_id' => $userId, 'resource_id' => $resourceId])->countAllResults() > 0;
    }

    public function grantAccess(int $userId, int $resourceId): bool
    {
        if ($this->hasAccess($userId, $resourceId)) {
            return true;
        }

        return (bool) $this->insert(['user_id' => $userId, 'resource_id' => $resourceId]);
    }

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function getResourceIdsByUser(int $userId): array
    {
        $rows = $this->select('resource_id')->where('user_id', $userId)->findAll();
        return array_map(static fn($row) => (int) ($row['resource_id'] ?? 0), $rows);
    }
}
