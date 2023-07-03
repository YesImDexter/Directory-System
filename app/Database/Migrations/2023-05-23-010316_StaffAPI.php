<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StaffAPI extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'staff_uid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'staff_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'staff_password' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'div_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            'staff_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_position' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_unit' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_desc' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_tel' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_office' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'staff_fax' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

        ]);
        $this->forge->addKey('staff_uid', true);
        $this->forge->createTable('staffAPI');
    }

    public function down()
    {
        $this->forge->dropTable('staffAPI');
    }
}
