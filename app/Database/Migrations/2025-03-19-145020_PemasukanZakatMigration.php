<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PemasukanZakatMigration extends Migration
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
            'nama' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'jumlah_keluarga' => ['type' => 'INT', 'constraint' => 11],
            'jenis_zakat' => [
                'type' => 'ENUM',
                'constraint' => ['Zakat Fitrah', 'Zakat Maal'],
                'default' => 'Zakat Fitrah',
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['uang', 'beras'],
                'default' => 'uang',
            ],
            'jumlah' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'null' => false,
            ],
            'infaq' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'null' => true,
            ],
            'tanggal_masuk' => [
                'type' => 'DATE',
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

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pemasukan_zakat');
    }

    public function down()
    {
        $this->forge->dropTable('pemasukan_zakat');
    }
}