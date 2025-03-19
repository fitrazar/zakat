<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenerimaZakat extends Migration
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
            'warga_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['uang', 'beras'],
                'default' => 'uang',
            ],
            'jumlah' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'tanggal_terima' => [
                'type' => 'DATE',
            ],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
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
        $this->forge->addForeignKey('warga_id', 'warga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penerima_zakat');
    }

    public function down()
    {
        $this->forge->dropTable('penerima_zakat');
    }
}