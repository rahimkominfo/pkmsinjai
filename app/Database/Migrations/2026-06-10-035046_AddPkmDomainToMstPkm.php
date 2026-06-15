<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPkmDomainToMstPkm extends Migration
{
    public function up()
    {
        $fields = [
            'pkm_domain' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'unique'     => true,
                'after'      => 'pkm_slug'
            ],
        ];
        $this->forge->addColumn('mst_pkm', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pkm', 'pkm_domain');
    }
}
