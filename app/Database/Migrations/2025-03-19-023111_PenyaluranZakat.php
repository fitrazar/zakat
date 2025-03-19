<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenyaluranZakat extends Migration
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
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['Fakir Miskin', 'Mualaf', 'Amil', 'Gharimin', 'Fisabilillah', 'Ibnu Sabil', 'Yatim Piatu'],
                'default' => 'Fakir Miskin',
            ],
            'jumlah' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('penyaluran_zakat');
    }

    public function down()
    {
        $this->forge->dropTable('penyaluran_zakat');
    }
}