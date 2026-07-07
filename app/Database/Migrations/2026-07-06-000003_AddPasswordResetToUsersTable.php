<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordResetToUsersTable extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('reset_token_hash', 'users')) {
            $fields['reset_token_hash'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'activation_token',
            ];
        }

        if (! $this->db->fieldExists('reset_token_expires_at', 'users')) {
            $fields['reset_token_expires_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'reset_token_hash',
            ];
        }

        if ($fields !== []) {
            $this->forge->addColumn('users', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('reset_token_expires_at', 'users')) {
            $this->forge->dropColumn('users', 'reset_token_expires_at');
        }

        if ($this->db->fieldExists('reset_token_hash', 'users')) {
            $this->forge->dropColumn('users', 'reset_token_hash');
        }
    }
}
