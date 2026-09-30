<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewsArticlesTable extends Migration
{
    public function up(): void
    {
        if ($this->db->tableExists('news_articles')) {
            return;
        }

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 190],
            'titre'        => ['type' => 'VARCHAR', 'constraint' => 220],
            'extrait'      => ['type' => 'TEXT', 'null' => true],
            'contenu'      => ['type' => 'LONGTEXT'],
            'video_urls'   => ['type' => 'LONGTEXT', 'null' => true],
            'statut'       => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'brouillon'],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['statut', 'published_at']);
        $this->forge->createTable('news_articles', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('news_articles', true);
    }
}
