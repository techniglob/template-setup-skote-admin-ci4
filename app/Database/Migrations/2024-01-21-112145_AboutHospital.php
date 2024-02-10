<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AboutHospital extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'affiliated_to' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'vice_chancellor' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'registrar' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'year_of_affiliation' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type'       => 'TEXT',
            ],
            'history_and_heritage' => [
                'type'       => 'TEXT',
            ],
            'map' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'address' => [
                'type'       => 'TEXT',
            ],
            'created_at datetime default current_timestamp',
            'created_by' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true
            ],
            'updated_at datetime default null on update current_timestamp',
            'updated_by' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'null'           => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('about_hospital', true);

    }

    public function down()
    {
        $this->forge->dropTable('about_hospital', true);
    }
}
