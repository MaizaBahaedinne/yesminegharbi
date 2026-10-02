<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePartnersTable extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('partners')) {
            return;
        }

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nom'         => ['type' => 'VARCHAR', 'constraint' => 160],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'instagram_url' => ['type' => 'VARCHAR', 'constraint' => 512, 'null' => true],
            'position'    => ['type' => 'SMALLINT', 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['is_active', 'position']);
        $this->forge->createTable('partners', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('partners', true);
    }
}
