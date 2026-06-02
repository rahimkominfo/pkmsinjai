<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMstMediaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'media_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tipe_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'ukuran_file' => [
                'type' => 'INT',
                'null' => true, // In bytes
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('media_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('deleted_at');
        $this->forge->createTable('mst_media', true);
    }

    public function down()
    {
        $this->forge->dropTable('mst_media', true);
    }
}
