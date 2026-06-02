<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Content extends Migration
{
    public function up()
    {
        // Kategori Table
        $this->forge->addField([
            'kategori_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'kategori_induk_id' => [
                'type' => 'INT',
                'null' => true,
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
        $this->forge->addKey('kategori_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('deleted_at');
        // If we want to create it:
        // $this->forge->createTable('mst_kategori', true); 

        // Artikel Table
        $this->forge->addField([
            'artikel_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'artikel_uuid' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'konten' => [
                'type' => 'LONGTEXT',
            ],
            'gambar_utama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'abstrak' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Draf', 'Ditayangkan', 'Diarsipkan'],
                'default'    => 'Draf',
            ],
            'jumlah_tayang' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'tanggal_publikasi' => [
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
        $this->forge->addKey('artikel_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('status');
        $this->forge->addKey('deleted_at');
        // $this->forge->createTable('trn_artikel', true);

        // Galeri Table
        $this->forge->addField([
            'galeri_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'pkm_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'sampul_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('galeri_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('deleted_at');
        // $this->forge->createTable('trn_galeri', true);

        // Galeri Gambar Table
        $this->forge->addField([
            'galeri_gambar_id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'galeri_id' => [
                'type' => 'INT',
            ],
            'pkm_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'gambar_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'caption' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('galeri_gambar_id', true);
        $this->forge->addKey('galeri_id');
        $this->forge->addKey('pkm_id');
        // $this->forge->createTable('trn_galeri_gambar', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_galeri_gambar', true);
        $this->forge->dropTable('trn_galeri', true);
        $this->forge->dropTable('trn_artikel', true);
        $this->forge->dropTable('mst_kategori', true);
    }
}
