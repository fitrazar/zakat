<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Dashboard Admin',
                'url' => '/admin/dashboard',
                'role' => 'admin',
            ],
            [
                'name' => 'Kelola User',
                'url' => '/admin/users',
                'role' => 'admin',
            ],

            [
                'name' => 'Dashboard RT',
                'url' => '/rt/dashboard',
                'role' => 'rt',
            ],
            [
                'name' => 'Data Warga',
                'url' => '/rt/warga',
                'role' => 'rt',
            ],

            [
                'name' => 'Dashboard Bendahara',
                'url' => '/bendahara/dashboard',
                'role' => 'bendahara',
            ],
            [
                'name' => 'Kelola Keuangan',
                'url' => '/bendahara/keuangan',
                'role' => 'bendahara',
            ],
        ];

        $this->db->table('menus')->insertBatch($data);
    }
}