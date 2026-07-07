<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResourceCountersToRessourcesTable extends Migration
{
    public function up(): void
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('ressources')) {
            return;
        }

        $fields = [];

        if (! $db->fieldExists('view_count', 'ressources')) {
            $fields['view_count'] = [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
                'after' => 'sort_order',
            ];
        }

        if (! $db->fieldExists('download_count', 'ressources')) {
            $fields['download_count'] = [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'null' => false,
                'after' => 'view_count',
            ];
        }

        if (! empty($fields)) {
            $this->forge->addColumn('ressources', $fields);
        }
    }

    public function down(): void
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('ressources')) {
            return;
        }

        if ($db->fieldExists('download_count', 'ressources')) {
            $this->forge->dropColumn('ressources', 'download_count');
        }

        if ($db->fieldExists('view_count', 'ressources')) {
            $this->forge->dropColumn('ressources', 'view_count');
        }
    }
}
