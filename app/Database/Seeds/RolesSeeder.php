<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $createdBy = 1;

        $roles = [
            [
                'role_name'    => 'super_admin',
                'display_name' => 'Super Admin',
                'created_at'   => $now,
                'created_by'   => $createdBy
            ],
            [
                'role_name'    => 'admin',
                'display_name' => 'Admin',
                'created_at'   => $now,
                'created_by'   => $createdBy
            ]
        ];

        $builder = $this->db->table('roles');

        foreach ($roles as $role) {
            $exists = $builder->where('role_name', $role['role_name'])->countAllResults();

            if (!$exists) {
                $builder->insert($role);
            }
        }
    }
}
