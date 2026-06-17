<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMstPagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'page_id' => [
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'konten' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Draf', 'Diterbitkan'],
                'default'    => 'Draf',
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
        $this->forge->addKey('page_id', true);
        $this->forge->addKey('pkm_id');
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->createTable('mst_pages', true);
    }

    public function down()
    {
        $this->forge->dropTable('mst_pages', true);
    }
}
