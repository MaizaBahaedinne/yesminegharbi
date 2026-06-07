<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewsletterAndContactTables extends Migration
{
    public function up(): void
    {
        // Newsletter subscribers
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'prenom'     => ['type' => 'VARCHAR', 'constraint' => 80, 'default' => ''],
            'tag'        => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'newsletter'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('newsletter_subscribers');

        // Contact messages
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nom'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'sujet'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'message'    => ['type' => 'TEXT'],
            'is_read'    => ['type' => 'TINYINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('contact_messages');
    }

    public function down(): void
    {
        $this->forge->dropTable('newsletter_subscribers');
        $this->forge->dropTable('contact_messages');
    }
}
