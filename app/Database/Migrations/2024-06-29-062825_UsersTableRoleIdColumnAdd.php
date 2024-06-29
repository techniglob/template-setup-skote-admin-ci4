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
        $this->db->query("ALTER TABLE users ADD CONSTRAINT fk_users_role_id FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE ON UPDATE NO ACTION");
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role_id');
    }
}
