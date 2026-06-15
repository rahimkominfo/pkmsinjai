<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMobileHeaderToPkm extends Migration
{
    public function up()
    {
        $fields = [
            'header_img_mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'header_img'
            ],
        ];
        $this->forge->addColumn('mst_pkm', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pkm', 'header_img_mobile');
    }
}
