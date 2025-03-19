<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WargaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Ahmad Syafiq',
                'alamat' => 'Jl. Merdeka No. 12, Jakarta',
                'jumlah_keluarga' => 4,
                'umur' => 35,
                'foto' => 'default.png',
                'no_hp' => '081234567890',
                'rt' => '01',
                'rw' => '02',
                'status' => 'Mampu',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Guru',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama' => 'Siti Aisyah',
                'alamat' => 'Jl. Kebangsaan No. 5, Bandung',
                'jumlah_keluarga' => 5,
                'umur' => 40,
                'foto' => 'default.png',
                'no_hp' => '081298765432',
                'rt' => '03',
                'rw' => '01',
                'status' => 'Tidak Mampu',
                'jenis_kelamin' => 'Perempuan',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('warga')->insertBatch($data);
    }
}