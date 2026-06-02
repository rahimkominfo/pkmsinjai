<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSysPeranTable extends Migration
{
    public function up()
    {
        // 1. Create sys_peran table
        $this->forge->addField([
            'peran_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_peran' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'deskripsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
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
        
        $this->forge->addKey('peran_id', true);
        $this->forge->createTable('sys_peran');
        
        // Insert default roles
        $db = \Config\Database::connect();
        $db->table('sys_peran')->insertBatch([
            ['nama_peran' => 'Admin Dinkes', 'deskripsi' => 'Administrator tingkat Kabupaten (Dinas Kesehatan)'],
            ['nama_peran' => 'Admin PKM', 'deskripsi' => 'Administrator Puskesmas (Tenant)'],
            ['nama_peran' => 'Editor', 'deskripsi' => 'Editor konten artikel dan berita'],
            ['nama_peran' => 'Penulis', 'deskripsi' => 'Penulis konten artikel dan berita'],
        ]);
        
        // 2. Add peran_id to sys_users
        $this->forge->addColumn('sys_users', [
            'peran_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'peran'
            ]
        ]);
        
        // 3. Migrate existing data
        $users = $db->table('sys_users')->get()->getResultArray();
        $roles = $db->table('sys_peran')->get()->getResultArray();
        
        $roleMap = [];
        foreach ($roles as $r) {
            $roleMap[$r['nama_peran']] = $r['peran_id'];
        }
        
        foreach ($users as $user) {
            if (isset($roleMap[$user['peran']])) {
                $db->table('sys_users')
                   ->where('user_id', $user['user_id'])
                   ->update(['peran_id' => $roleMap[$user['peran']]]);
            }
        }
        
        // 4. Make peran_id not null and add foreign key (if desired, CodeIgniter doesn't strictly require DB-level FKs but it's good practice. We'll skip strict FK for simplicity to avoid constraint issues, just drop old column)
        
        // Note: For safe rollback, dropping column might be risky in some databases, but we'll drop `peran` column.
        $this->forge->dropColumn('sys_users', 'peran');
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // Recreate peran column
        $this->forge->addColumn('sys_users', [
            'peran' => [
                'type' => 'ENUM("Admin Dinkes","Admin PKM","Editor","Penulis")',
                'default' => 'Penulis',
                'after' => 'password'
            ]
        ]);
        
        // Attempt to restore data based on peran_id
        $users = $db->table('sys_users')->get()->getResultArray();
        $roles = $db->table('sys_peran')->get()->getResultArray();
        $roleMap = [];
        foreach ($roles as $r) {
            $roleMap[$r['peran_id']] = $r['nama_peran'];
        }
        
        foreach ($users as $user) {
            if (isset($roleMap[$user['peran_id']])) {
                $db->table('sys_users')
                   ->where('user_id', $user['user_id'])
                   ->update(['peran' => $roleMap[$user['peran_id']]]);
            }
        }
        
        $this->forge->dropColumn('sys_users', 'peran_id');
        $this->forge->dropTable('sys_peran');
    }
}
