<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AntrianMigration extends Migration
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
                'unsigned'   => true,
                'null'       => true, // Nullable to allow global if needed, though usually filled
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'loket' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nomor' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'petugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'img' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'dilayani', 'selesai', 'batal'],
                'default'    => 'dilayani',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        
        // Indexing pada kolom filter sesuai request
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('tanggal');
        $this->forge->addKey('status');
        
        $this->forge->createTable('trn_antrian', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_antrian', true);
    }
}
