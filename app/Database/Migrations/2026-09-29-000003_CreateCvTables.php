<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCvTables extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'unsigned' => true],
            'titre'      => ['type' => 'VARCHAR', 'constraint' => 120],
            'langue'     => ['type' => 'VARCHAR', 'constraint' => 2, 'default' => 'fr'],
            'data'       => ['type' => 'LONGTEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('user_id');
        $this->forge->createTable('cvs', true);

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'unsigned' => true],
            'cv_id'      => ['type' => 'INT', 'unsigned' => true],
            'job_title'  => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'offer_text' => ['type' => 'MEDIUMTEXT', 'null' => true],
            'score'      => ['type' => 'TINYINT', 'unsigned' => true, 'default' => 0],
            'result'     => ['type' => 'MEDIUMTEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['user_id', 'created_at']);
        $this->forge->addKey('cv_id');
        $this->forge->createTable('cv_ats_tests', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('cv_ats_tests', true);
        $this->forge->dropTable('cvs', true);
    }
}
