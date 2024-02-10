<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Documents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'doc_type' => [
                'type' => 'ENUM',
                'null'    => true,
                'constraint'    => ['NOTICE','TENDER','NE','ARS','MENU'],
                'comment'    => 'NE For News/Events ARS For Anti Ragging Section'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'default'    => 1,
                'constraint'    => 1,
                'comment'    => '0 for no 1 for yes'
            ],
            'created_at datetime default current_timestamp',
            'created_by' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true
            ],
            'updated_at datetime default null',
            'updated_by' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'null'           => true
            ],
            'deleted_at datetime default null',
            'deleted_by' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'null'           => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('documents', true);

    }

    public function down()
    {
        $this->forge->dropTable('documents', true);
    }
}
