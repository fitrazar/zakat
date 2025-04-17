<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KasZakat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['uang', 'beras', 'infaq'],
            ],
            'saldo_masuk' => [ // Total pemasukan zakat
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => 0.00,
            ],
            'saldo_keluar' => [ // Total penerima zakat
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => 0.00,
            ],
            'saldo_akhir' => [ // Saldo saat ini (saldo_masuk - saldo_keluar)
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => 0.00,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kas_zakat');
    }

    public function down()
    {
        $this->forge->dropTable('kas_zakat');
    }
}