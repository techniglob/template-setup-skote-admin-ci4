<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_name'       => 'super_admin',
                'display_name'    => 'Super admin',
                'created_at'      => date('Y-m-d H:i:s'),
                'created_by'      => 1
            ], [
                'role_name'       => 'admin',
                'display_name'    => 'Admin',
                'created_at'      => date('Y-m-d H:i:s'),
                'created_by'      => 1
            ]
        ];
        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}
