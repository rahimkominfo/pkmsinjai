<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMstFlyerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'flayer_id' => [
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'gambar_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default'    => 'Aktif',
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        
        $this->forge->addKey('flayer_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('uuid');
        $this->forge->addKey('status');
        $this->forge->createTable('mst_flyer', true);
    }

    public function down()
    {
        $this->forge->dropTable('mst_flyer', true);
    }
}
