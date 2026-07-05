<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table      = 'settings';
    protected $primaryKey = 'key';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['key', 'value'];
    protected $useTimestamps    = true;
    protected $updatedField     = 'updated_at';
    protected $createdField     = '';

    /** Retourne toutes les settings sous forme clé => valeur */
    public function getAll(): array
    {
        $rows = $this->findAll();
        $out  = [];
        foreach ($rows as $r) {
            $out[$r['key']] = $r['value'];
        }
        return $out;
    }

    /** Sauvegarde un tableau clé => valeur (INSERT OR UPDATE) */
    public function saveAll(array $data): void
    {
        $db = $this->db;
        foreach ($data as $key => $value) {
            $db->query(
                "INSERT INTO settings (`key`, `value`) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = NOW()",
                [$key, $value]
            );
        }
    }
}
