<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatistikPenyakitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'kode_diagnosa' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'diagnosa' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jumlah_lk' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'jumlah_pr' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'total' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'periode_awal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'periode_akhir' => [
                'type' => 'DATE',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['pkm_id', 'kode_diagnosa', 'periode_awal', 'periode_akhir']);
        $this->forge->addForeignKey('pkm_id', 'mst_pkm', 'pkm_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_statistik_penyakit');
    }

    public function down()
    {
        $this->forge->dropTable('trn_statistik_penyakit');
    }
}
