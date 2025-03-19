<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenerimaZakatSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'warga_id' => 1,
                'jenis_zakat' => 'uang',
                'jumlah' => 50000,
                'satuan' => 'Rp',
                'tanggal_terima' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'warga_id' => 2,
                'jenis_zakat' => 'beras',
                'jumlah' => 2.5,
                'satuan' => 'kg',
                'tanggal_terima' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('penerima_zakat')->insertBatch($data);
    }
}