<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVideoUrlToRessourcesTable extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('ressources') && ! $this->db->fieldExists('video_url', 'ressources')) {
            $this->forge->addColumn('ressources', [
                'video_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'fichier_path'],
            ]);
        }
    }

    public function down(): void
    {
        if ($this->db->tableExists('ressources') && $this->db->fieldExists('video_url', 'ressources')) {
            $this->forge->dropColumn('ressources', 'video_url');
        }
    }
}
