<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'formation_id' => ['type' => 'INT'],
            'titre'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'  => ['type' => 'TEXT', 'null' => true],
            'position'     => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('formation_id', 'formations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('modules');

        // Leçons
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'module_id'  => ['type' => 'INT'],
            'titre'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'video_url'  => ['type' => 'VARCHAR', 'constraint' => 512, 'null' => true],
            'duree'      => ['type' => 'SMALLINT', 'default' => 0, 'comment' => 'secondes'],
            'position'   => ['type' => 'SMALLINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('module_id', 'modules', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lecons');
    }

    public function down(): void
    {
        $this->forge->dropTable('lecons');
        $this->forge->dropTable('modules');
    }
}
