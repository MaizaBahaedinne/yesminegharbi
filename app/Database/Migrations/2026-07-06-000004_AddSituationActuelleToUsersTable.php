<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSituationActuelleToUsersTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('situation_actuelle', 'users')) {
            $this->forge->addColumn('users', [
                'situation_actuelle' => [
                    'type' => 'VARCHAR',
                    'constraint' => 120,
                    'null' => true,
                    'after' => 'date_naissance',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('situation_actuelle', 'users')) {
            $this->forge->dropColumn('users', 'situation_actuelle');
        }
    }
}
