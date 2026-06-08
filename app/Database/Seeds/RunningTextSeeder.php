<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RunningTextSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $data = [
            // PKM Balangnipa (ID 1)
            [
                'pkm_id'    => 1,
                'teks'      => 'Selamat Datang di Portal Resmi Puskesmas Balangnipa - Melayani dengan Hati, Sehatkan Negeri.',
                'is_active' => 1,
                'created_at' => Time::now()->toDateTimeString(),
            ],
            [
                'pkm_id'    => 1,
                'teks'      => 'Ingat! Selalu Jaga Kebersihan Tangan dan Gunakan Masker Saat Berada di Lingkungan Puskesmas.',
                'is_active' => 1,
                'created_at' => Time::now()->toDateTimeString(),
            ],
            // PKM Panaikang (ID 2)
            [
                'pkm_id'    => 2,
                'teks'      => 'Layanan Pengaduan Masyarakat Puskesmas Panaikang Kini Tersedia Via WhatsApp di Nomor 0812-3456-7890.',
                'is_active' => 1,
                'created_at' => Time::now()->toDateTimeString(),
            ],
            // PKM Samataring (ID 3)
            [
                'pkm_id'    => 3,
                'teks'      => 'Jadwal Imunisasi Rutin Setiap Hari Rabu Pukul 08.00 - 12.00 WITA di Puskesmas Samataring.',
                'is_active' => 1,
                'created_at' => Time::now()->toDateTimeString(),
            ],
        ];

        $db->table('mst_running_text')->insertBatch($data);
    }
}
