<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'superadmin',
            'role_id' => 1,
            'email'    => 'superadmin@example.com',
            'mobile'    => '1234567890',
            'full_name'    => 'Super Admin',
            'password'    => password_hash(123456,  PASSWORD_DEFAULT),
            'created_at'    => date('Y-m-d H:i:s'),
            'created_by'    => 1
        ];
        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
