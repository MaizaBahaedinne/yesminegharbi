<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRessourcesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'auto_increment' => true],
            'slug'               => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'titre'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'description_courte' => ['type' => 'TEXT'],
            'description_longue' => ['type' => 'LONGTEXT', 'null' => true],
            'type'               => ['type' => 'ENUM', 'constraint' => ['guide','template','checklist','ebook','kit'], 'default' => 'guide'],
            'profil'             => ['type' => 'ENUM', 'constraint' => ['junior','experimente','recruteur','tous'], 'default' => 'tous'],
            'prix'               => ['type' => 'DECIMAL', 'constraint' => '8,3', 'default' => '0.000'],
            'fichier_path'       => ['type' => 'VARCHAR', 'constraint' => 512, 'null' => true],
            'cover_image'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_premium'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'tag_badge'          => ['type' => 'ENUM', 'constraint' => ['gratuit','premium','nouveau','populaire'], 'default' => 'gratuit'],
            'sort_order'         => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('ressources');
    }

    public function down(): void
    {
        $this->forge->dropTable('ressources');
    }
}
