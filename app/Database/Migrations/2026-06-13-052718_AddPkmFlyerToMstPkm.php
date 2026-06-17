<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPkmFlyerToMstPkm extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mst_pkm', [
            'pkm_flyer' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pkm', 'pkm_flyer');
    }
}
