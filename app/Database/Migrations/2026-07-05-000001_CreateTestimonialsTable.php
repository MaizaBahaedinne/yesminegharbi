<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 9, 'unsigned' => true, 'auto_increment' => true],
            'quote'          => ['type' => 'TEXT', 'null' => false],
            'author_name'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'author_role'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'rating'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'avatar_initials'=> ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'avatar_color'   => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'position'       => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials');
    }

    public function down(): void
    {
        $this->forge->dropTable('testimonials');
    }
}
