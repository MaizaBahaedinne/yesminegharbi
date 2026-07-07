<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResourceOrdersTable extends Migration
{
    public function up(): void
    {
        $db = \Config\Database::connect();

        if ($db->tableExists('resource_orders')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'resource_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'order_number' => ['type' => 'VARCHAR', 'constraint' => 40],
            'base_amount' => ['type' => 'DECIMAL', 'constraint' => '10,3', 'default' => '0.000'],
            'discount_amount' => ['type' => 'DECIMAL', 'constraint' => '10,3', 'default' => '0.000'],
            'total_amount' => ['type' => 'DECIMAL', 'constraint' => '10,3', 'default' => '0.000'],
            'currency' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'TND'],
            'promo_code' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 40, 'default' => 'simulation_online'],
            'payment_status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'paid'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'confirmed'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('order_number', false, true);
        $this->forge->addKey(['user_id', 'resource_id']);
        $this->forge->createTable('resource_orders', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('resource_orders', true);
    }
}
