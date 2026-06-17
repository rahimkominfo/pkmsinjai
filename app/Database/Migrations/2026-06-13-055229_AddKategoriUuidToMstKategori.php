<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriUuidToMstKategori extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mst_kategori', [
            'kategori_uuid' => [
                'type'       => 'VARCHAR',
                'constraint' => 36,
                'null'       => true,
                'after'      => 'kategori_id'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_kategori', 'kategori_uuid');
    }
}
