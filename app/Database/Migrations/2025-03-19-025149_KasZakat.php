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
            'jenis' => [ // uang atau beras
                'type' => 'ENUM',
                'constraint' => ['uang', 'beras'],
            ],
            'saldo_masuk' => [ // Total penerimaan zakat
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'saldo_keluar' => [ // Total penyaluran zakat
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'saldo_akhir' => [ // Saldo saat ini (saldo_masuk - saldo_keluar)
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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