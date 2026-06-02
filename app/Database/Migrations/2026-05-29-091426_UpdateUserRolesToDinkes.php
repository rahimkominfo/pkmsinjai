<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRolesToDinkes extends Migration
{
    public function up()
    {
        // Change role enum constraint
        $fields = [
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin Dinkes', 'Admin PKM', 'Editor', 'Penulis'],
                'default'    => 'Penulis',
            ],
        ];
        $this->forge->modifyColumn('sys_users', $fields);

        // Map existing roles if necessary
        $this->db->table('sys_users')->where('peran', 'Admin')->update(['peran' => 'Admin PKM']);
    }

    public function down()
    {
        $fields = [
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['Admin', 'Editor', 'Penulis'],
                'default'    => 'Penulis',
            ],
        ];
        $this->forge->modifyColumn('sys_users', $fields);
        
        $this->db->table('sys_users')->where('peran', 'Admin PKM')->update(['peran' => 'Admin']);
        $this->db->table('sys_users')->where('peran', 'Admin Dinkes')->update(['peran' => 'Admin']);
    }
}
