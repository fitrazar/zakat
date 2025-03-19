<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Warga extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 255],
            'alamat' => ['type' => 'TEXT'],
            'jumlah_keluarga' => ['type' => 'INT', 'constraint' => 11],
            'umur' => ['type' => 'INT', 'constraint' => 3],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'default.png'],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 15],
            'rt' => ['type' => 'VARCHAR', 'constraint' => 5],
            'rw' => ['type' => 'VARCHAR', 'constraint' => 5],
            'status' => ['type' => 'ENUM', 'constraint' => ['Mampu', 'Tidak Mampu'], 'default' => 'Mampu'],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['Laki - Laki', 'Perempuan']],
            'pekerjaan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('warga');
    }

    public function down()
    {
        $this->forge->dropTable('warga');
    }
}