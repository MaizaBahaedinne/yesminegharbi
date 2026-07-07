<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivationCodeToUsersTable extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('activation_code', 'users')) {
            $fields['activation_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => true,
                'after' => 'activation_token',
            ];
        }

        if (! $this->db->fieldExists('activation_code_expires_at', 'users')) {
            $fields['activation_code_expires_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'activation_code',
            ];
        }

        if ($fields !== []) {
            $this->forge->addColumn('users', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('activation_code_expires_at', 'users')) {
            $this->forge->dropColumn('users', 'activation_code_expires_at');
        }

        if ($this->db->fieldExists('activation_code', 'users')) {
            $this->forge->dropColumn('users', 'activation_code');
        }
    }
}
