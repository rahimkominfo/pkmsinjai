<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMottoToPkm extends Migration
{
    public function up()
    {
        $fields = [
            'pkm_motto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'header_img_mobile'
            ],
        ];
        $this->forge->addColumn('mst_pkm', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pkm', 'pkm_motto');
    }
}
