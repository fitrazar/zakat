<?php

namespace App\Database\Seeds;

use Faker\Factory;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $data = [];

        $data[] = [
            'name' => 'Admin',
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
        ];

        $data[] = [
            'name' => 'Asep Mulyana',
            'username' => 'rt',
            'password' => password_hash('rt123', PASSWORD_DEFAULT),
            'role' => 'rt',
        ];

        $data[] = [
            'name' => 'Bendahara',
            'username' => 'bendahara',
            'password' => password_hash('bendahara123', PASSWORD_DEFAULT),
            'role' => 'bendahara',
        ];

        $this->db->table('users')->insertBatch($data);
    }
}