<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        
        // Kosongkan tabel sys_users
        $this->db->table('sys_users')->emptyTable();
        
        // Aktifkan kembali foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil data peran
        $peranModel = new \App\Models\PeranModel();
        $roles = $peranModel->findAll();

        if (empty($roles)) {
            echo "Error: Tabel sys_peran kosong. Pastikan migrasi peran sudah dijalankan.\n";
            return;
        }

        // Ambil data PKM
        $pkmModel = new \App\Models\PkmModel();
        $pkms = $pkmModel->findAll();
        
        $pkmIds = array_column($pkms, 'pkm_id');
        $samplePkmId = !empty($pkmIds) ? $pkmIds[0] : null;

        $passwordHash = password_hash('admin123', PASSWORD_BCRYPT);
        
        $data = [];

        // Buat Super Admin (Dinkes) - Akses ke pkm_id = 'super'
        $adminDinkesRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Admin Dinkes');
        $adminDinkesRoleId = !empty($adminDinkesRole) ? array_values($adminDinkesRole)[0]['peran_id'] : $roles[0]['peran_id'];

        $data[] = [
            'user_uuid'   => bin2hex(random_bytes(16)),
            'pkm_id'      => 'super',
            'username'    => 'dinkesadmin',
            'email'       => 'dinkes@sinjaikab.go.id',
            'password'    => $passwordHash,
            'nama_publik' => 'Administrator Dinkes',
            'peran_id'    => $adminDinkesRoleId,
            'tanggal_daftar'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Buat Admin PKM untuk PKM pertama (jika ada)
        $adminPkmRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Admin PKM');
        $adminPkmRoleId = !empty($adminPkmRole) ? array_values($adminPkmRole)[0]['peran_id'] : $roles[0]['peran_id'];

        if ($samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'adminpkm1',
                'email'       => 'adminpkm1@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Admin PKM Satu',
                'peran_id'    => $adminPkmRoleId,
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Buat Editor
        $editorRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Editor');
        $editorRoleId = !empty($editorRole) ? array_values($editorRole)[0]['peran_id'] : $roles[0]['peran_id'];

        if ($samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'editorpkm1',
                'email'       => 'editorpkm1@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Editor Berita',
                'peran_id'    => $editorRoleId,
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Buat Penulis
        $penulisRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Penulis');
        $penulisRoleId = !empty($penulisRole) ? array_values($penulisRole)[0]['peran_id'] : $roles[0]['peran_id'];

        if ($samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'penulispkm1',
                'email'       => 'penulispkm1@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Penulis Artikel',
                'peran_id'    => $penulisRoleId,
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Buat Pendaftaran
        $pendaftaranRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Pendaftaran');
        if (!empty($pendaftaranRole) && $samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'pendaftaran1',
                'email'       => 'pendaftaran@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Petugas Pendaftaran',
                'peran_id'    => array_values($pendaftaranRole)[0]['peran_id'],
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Buat Poli Umum
        $poliUmumRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Poli Umum');
        if (!empty($poliUmumRole) && $samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'poliumum1',
                'email'       => 'poliumum@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Petugas Poli Umum',
                'peran_id'    => array_values($poliUmumRole)[0]['peran_id'],
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Buat Poli Gigi
        $poliGigiRole = array_filter($roles, fn($r) => $r['nama_peran'] === 'Poli Gigi');
        if (!empty($poliGigiRole) && $samplePkmId) {
            $data[] = [
                'user_uuid'   => bin2hex(random_bytes(16)),
                'pkm_id'      => $samplePkmId,
                'username'    => 'poligigi1',
                'email'       => 'poligigi@pkm.go.id',
                'password'    => $passwordHash,
                'nama_publik' => 'Petugas Poli Gigi',
                'peran_id'    => array_values($poliGigiRole)[0]['peran_id'],
                'tanggal_daftar'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Generate data for all pkms if possible to ensure each tenant has at least an admin
        if (!empty($pkms)) {
            foreach ($pkms as $pkm) {
                // Skip the first one as we already added it above
                if ($pkm['pkm_id'] === $samplePkmId) continue;
                
                $data[] = [
                    'user_uuid'   => bin2hex(random_bytes(16)),
                    'pkm_id'      => $pkm['pkm_id'],
                    'username'    => 'admin_' . $pkm['pkm_slug'],
                    'email'       => 'admin@' . $pkm['pkm_slug'] . '.go.id',
                    'password'    => $passwordHash,
                    'nama_publik' => 'Admin ' . $pkm['pkm_nama'],
                    'peran_id'    => $adminPkmRoleId,
                    'tanggal_daftar'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }

        // Insert data
        if (!empty($data)) {
            $this->db->table('sys_users')->insertBatch($data);
            echo "Seeder sys_users berhasil dijalankan. Password: admin123\n";
        }
    }
}
