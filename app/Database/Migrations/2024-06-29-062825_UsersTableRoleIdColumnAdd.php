<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersTableRoleIdColumnAdd extends Migration
{
    public function up()
    {
        $fields = [
            'role_id' => [
                'type'          => "BIGINT",
                'unsigned'      => true,
                'constraint'    => 20,
                'null'          => true,
                'after'         => 'id'
            ]
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role_id');
    }
}
