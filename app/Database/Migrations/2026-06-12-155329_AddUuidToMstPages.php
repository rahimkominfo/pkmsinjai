<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUuidToMstPages extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mst_pages', [
            'page_uuid' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => true,
                'after'      => 'pkm_id'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pages', 'page_uuid');
    }
}
