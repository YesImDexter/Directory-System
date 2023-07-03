<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DivisionAPI extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'div_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],

            'camp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'div_name' => [
                'type' => 'TEXT',
                'constraint' => 100,
                'null' => true,
            ],

            'div_image' => [
                'type'       => 'TEXT',
                'constraint' => 100,
            ],

            'div_desc' => [
                'type'       => 'TEXT',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('div_id', true);
        $this->forge->createTable('divAPI');
    }

    public function down()
    {
        $this->forge->dropTable('divAPI');
    }
}
