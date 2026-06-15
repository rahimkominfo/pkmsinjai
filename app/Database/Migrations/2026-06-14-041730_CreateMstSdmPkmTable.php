<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMstSdmPkmTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sdm_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'foto_pegawai' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'profesi_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'unit_poli' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        
        $this->forge->addKey('sdm_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('uuid');
        $this->forge->createTable('mst_sdm_pkm', true);
    }

    public function down()
    {
        $this->forge->dropTable('mst_sdm_pkm', true);
    }
}
