<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoleToPenulis extends Migration
{
    public function up()
    {
        // 1. Update data existing dari Kontributor ke Penulis
        $this->db->table('sys_users')
                 ->where('peran', 'Kontributor')
                 ->update(['peran' => 'Penulis']);

        // 2. Jika kolom 'peran' adalah ENUM, kita perlu memperbarui definisinya
        // Meskipun di migration awal mungkin VARCHAR, demi keamanan kita definisikan ulang
        $fields = [
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin', 'Editor', 'Penulis'],
                'default'    => 'Penulis',
            ],
        ];
        $this->forge->modifyColumn('sys_users', $fields);
    }

    public function down()
    {
        // Kebalikannya jika rollback
        $this->db->table('sys_users')
                 ->where('peran', 'Penulis')
                 ->update(['peran' => 'Kontributor']);

        $fields = [
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin', 'Editor', 'Kontributor'],
                'default'    => 'Kontributor',
            ],
        ];
        $this->forge->modifyColumn('sys_users', $fields);
    }
}
