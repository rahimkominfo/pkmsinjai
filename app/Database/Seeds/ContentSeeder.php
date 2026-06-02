<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Check if users exist, create if not
        $user = $db->table('sys_users')->where('username', 'admin')->get()->getRowArray();
        if (!$user) {
            $db->table('sys_users')->insert([
                'pkm_id' => 1,
                'username' => 'admin',
                'password' => password_hash('sembarangji', PASSWORD_BCRYPT),
                'email' => 'admin@pkm.com',
                'nama_publik' => 'Admin PKM',
                'peran' => 'Admin'
            ]);
            $userId = $db->insertID();
        } else {
            $userId = $user['user_id'];
        }

        // Insert Artikel Dummy
        $dataArtikel = [
            [
                'pkm_id' => 1,
                'artikel_uuid' => 'uuid-1',
                'judul' => 'Puskesmas Balangnipa Hadirkan Layanan Kesehatan Digital Terpadu',
                'slug' => 'puskesmas-balangnipa-hadirkan-layanan-kesehatan-digital',
                'konten' => 'Kami berkomitmen memberikan pelayanan prima. Kini daftar antrean dan cek riwayat kesehatan dapat dilakukan dengan mudah dari rumah.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDl9lBDZGj4FMKYjn8qNjMMXKLrsn2yarly_C7FkwYi91u8pi_0fzrCkeqFusCTDW8LSLG67jA91XFDXlpS8ZQG3n95aZ1Jkst2ONGDWdcfa4Xb2P-U-ity3rBIW6-rrqUKpJQfS0KVjpizvkfeu2sd18n_Qyd1vdFP2fVuxEk8InA9H59wa-4iO0cMfKKT8Qtv3NgDzFOrgoZGE7Ij9cUpr_BePChJnoqF6586JTyPH8jwcYlcKYogOPMBPLOYz4mT_JlqaS07LdwP',
                'abstrak' => 'Kami berkomitmen memberikan pelayanan prima.',
                'user_id' => $userId,
                'status' => 'Ditayangkan',
                'tanggal_publikasi' => Time::now()->toDateTimeString(),
            ],
            [
                'pkm_id' => 1,
                'artikel_uuid' => 'uuid-2',
                'judul' => 'Pentingnya Asupan Gizi Seimbang untuk Mencegah Stunting pada Balita',
                'slug' => 'pentingnya-asupan-gizi-seimbang',
                'konten' => 'Puskesmas Balangnipa kembali mengadakan penyuluhan gizi seimbang di berbagai posyandu. Langkah ini diambil sebagai upaya percepatan penurunan angka stunting di wilayah kerja kami.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzDdYpLefQYDVWdfCL-ZdpsrLIvSnQZfjbGd5C01UKL9kVqEEex6IavgHM_xu11ciEGXWi7zOaVRPmUmvfxhk526QD6Q_tYclkvyl5uAV-LRUnrWln5YAIGl3n6-qZlkXNqsG7tTjbWw14Jf0AF8dU_Bp6L9COssFuvxkHP9ifEzgVn--pOp9uzlNVIQsKjk21dFLmx-b2bnN4eK3hLUk9pAVh03krHJHYVt28uKYOcQ6pzdpF1GVPBhJiii9LFTxnN-ce2h-RDMEG',
                'abstrak' => 'Penyuluhan gizi seimbang untuk pencegahan stunting.',
                'user_id' => $userId,
                'status' => 'Ditayangkan',
                'tanggal_publikasi' => Time::now()->subHours(2)->toDateTimeString(),
            ],
            [
                'pkm_id' => 1,
                'artikel_uuid' => 'uuid-3',
                'judul' => 'Jadwal Pelayanan Imunisasi Dasar Lengkap Bulan Ini',
                'slug' => 'jadwal-pelayanan-imunisasi-dasar',
                'konten' => 'Berikut adalah jadwal pelayanan imunisasi dasar lengkap untuk bulan ini. Pastikan buah hati Anda mendapatkan imunisasi tepat waktu.',
                'gambar_utama' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDPNCgJ4daHKMR8s-jOYqZoiYS_kdFFE1pW2sSiP49ox5_9dud45ijwHCVryJeZ4WeCIGb1Kv1bI7AqsBZNqbyilwJvKkS5TfMjuHGsC6A4a10BwRHrkA5_5jjq7sg1rHRPphOgqHrsjAKYSOVIk3DsH2JP6-izjECNvG9Rl2bnCaZfx_HmYTm_sUnXP4myOMwIwchrMaByQxlzOrWtd7SfkXws4DKSHjcIMSNdyTeMvxVtah-YmZD1RopRWBqRbw5b5hmJMEUcFr7t',
                'abstrak' => 'Informasi layanan imunisasi dasar lengkap.',
                'user_id' => $userId,
                'status' => 'Ditayangkan',
                'tanggal_publikasi' => Time::now()->subDays(1)->toDateTimeString(),
            ]
        ];
        
        $db->table('trn_artikel')->insertBatch($dataArtikel);

        // Insert Galeri Dummy
        $dataGaleri = [
            [
                'pkm_id' => 1,
                'judul' => 'Dokumentasi Kegiatan Posyandu Balita & Lansia',
                'sampul_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDl9lBDZGj4FMKYjn8qNjMMXKLrsn2yarly_C7FkwYi91u8pi_0fzrCkeqFusCTDW8LSLG67jA91XFDXlpS8ZQG3n95aZ1Jkst2ONGDWdcfa4Xb2P-U-ity3rBIW6-rrqUKpJQfS0KVjpizvkfeu2sd18n_Qyd1vdFP2fVuxEk8InA9H59wa-4iO0cMfKKT8Qtv3NgDzFOrgoZGE7Ij9cUpr_BePChJnoqF6586JTyPH8jwcYlcKYogOPMBPLOYz4mT_JlqaS07LdwP',
                'deskripsi' => 'Kegiatan rutin posyandu balita dan lansia.',
                'created_at' => Time::now()->toDateTimeString(),
            ]
        ];
        
        $db->table('trn_galeri')->insertBatch($dataGaleri);
        $galeriId = $db->insertID();

        // Insert Galeri Gambar
        $dataGambar = [
            ['galeri_id' => $galeriId, 'pkm_id' => 1, 'gambar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDl9lBDZGj4FMKYjn8qNjMMXKLrsn2yarly_C7FkwYi91u8pi_0fzrCkeqFusCTDW8LSLG67jA91XFDXlpS8ZQG3n95aZ1Jkst2ONGDWdcfa4Xb2P-U-ity3rBIW6-rrqUKpJQfS0KVjpizvkfeu2sd18n_Qyd1vdFP2fVuxEk8InA9H59wa-4iO0cMfKKT8Qtv3NgDzFOrgoZGE7Ij9cUpr_BePChJnoqF6586JTyPH8jwcYlcKYogOPMBPLOYz4mT_JlqaS07LdwP', 'caption' => 'Foto 1'],
            ['galeri_id' => $galeriId, 'pkm_id' => 1, 'gambar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBzDdYpLefQYDVWdfCL-ZdpsrLIvSnQZfjbGd5C01UKL9kVqEEex6IavgHM_xu11ciEGXWi7zOaVRPmUmvfxhk526QD6Q_tYclkvyl5uAV-LRUnrWln5YAIGl3n6-qZlkXNqsG7tTjbWw14Jf0AF8dU_Bp6L9COssFuvxkHP9ifEzgVn--pOp9uzlNVIQsKjk21dFLmx-b2bnN4eK3hLUk9pAVh03krHJHYVt28uKYOcQ6pzdpF1GVPBhJiii9LFTxnN-ce2h-RDMEG', 'caption' => 'Foto 2'],
        ];
        $db->table('trn_galeri_gambar')->insertBatch($dataGambar);
    }
}
