<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'key'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'value'      => ['type' => 'TEXT', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('key');
        $this->forge->createTable('settings');

        // Default settings
        $this->db->table('settings')->insertBatch([
            ['key' => 'site_name',        'value' => 'Yesmine Gharbi'],
            ['key' => 'site_email',       'value' => 'contact@yesminegharbi.com'],
            ['key' => 'site_phone',       'value' => ''],
            ['key' => 'site_description', 'value' => ''],
            ['key' => 'facebook_url',     'value' => ''],
            ['key' => 'instagram_url',    'value' => ''],
            ['key' => 'linkedin_url',     'value' => ''],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropTable('settings');
    }
}
