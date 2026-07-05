<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormationsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'slug'                => ['type' => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'titre'               => ['type' => 'VARCHAR', 'constraint' => 255],
            'description_courte'  => ['type' => 'TEXT'],
            'description_longue'  => ['type' => 'LONGTEXT', 'null' => true],
            'prix'                => ['type' => 'DECIMAL', 'constraint' => '8,3', 'default' => '0.000'],
            'niveau'              => ['type' => 'ENUM', 'constraint' => ['junior','experimente','tous'], 'default' => 'tous'],
            'theme'               => ['type' => 'ENUM', 'constraint' => ['cv','entretien','recrutement','branding'], 'default' => 'cv'],
            'statut'              => ['type' => 'ENUM', 'constraint' => ['disponible','bientot','archive'], 'default' => 'bientot'],
            'modules_count'       => ['type' => 'TINYINT', 'default' => 0],
            'heures'              => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => ''],
            'cover_image'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_populaire'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order'          => ['type' => 'SMALLINT', 'default' => 0],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('formations');
    }

    public function down(): void
    {
        $this->forge->dropTable('formations');
    }
}
