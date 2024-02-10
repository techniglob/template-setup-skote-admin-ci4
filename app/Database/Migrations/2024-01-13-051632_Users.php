<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'mobile' => [
                'type'       => 'BIGINT',
                'constraint' => '10',
                'null'       => true
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'profile_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'default.png'
            ],
            'generate_token' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null'    => true
            ],
            'generate_on' => [
                'type' => 'DATETIME',
                'null'    => true,
            ],
            'is_online' => [
                'type' => 'TINYINT',
                'default'    => 0,
                'comment'    => '0 for offline 1 for online'
            ],
            'is_block' => [
                'type' => 'TINYINT',
                'default'    => 0,
                'comment'    => '0 for offline 1 for online'
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'default'    => 1,
                'comment'    => '0 for no 1 for yes'
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
                'null'           =>true
            ],
            'deleted_at datetime default null',
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addUniqueKey('email','uq_users_email');
        $this->forge->addUniqueKey('username','uq_users_username');
        $this->forge->createTable('users', true);

    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
