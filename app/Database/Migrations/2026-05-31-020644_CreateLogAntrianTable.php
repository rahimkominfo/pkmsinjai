<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogAntrianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'antrian_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'peran_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nomor_terakhir' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'total_pengunjung' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'default'    => 0,
            ],
            'tanggal' => [
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
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('antrian_id');
        $this->forge->addKey('tanggal');
        $this->forge->createTable('log_antrian');
    }

    public function down()
    {
        $this->forge->dropTable('log_antrian');
    }
}
