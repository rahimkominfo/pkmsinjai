<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPeranIdToAntrian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('trn_antrian', [
            'peran_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'pkm_id',
            ],
        ]);
        
        $this->forge->addKey('peran_id');
        // If we want foreign key constraints, we can add them in a direct query or forge
        $this->db->query('ALTER TABLE trn_antrian ADD CONSTRAINT fk_antrian_peran FOREIGN KEY (peran_id) REFERENCES sys_peran(peran_id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE trn_antrian DROP FOREIGN KEY fk_antrian_peran');
        $this->forge->dropColumn('trn_antrian', 'peran_id');
    }
}
