<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\UserModel;
use App\Models\LogAntrianModel;

class Dashboard extends BaseAdminController
{
    public function index()
    {
        $artikelModel = new ArtikelModel();
        $userModel = new UserModel();
        
        $pkm_id = tenant()->pkm_id;
        
        $builderArtikel = $artikelModel->builder();
        $builderUser = $userModel->builder();
        
        $builderArtikel->where('trn_artikel.deleted_at IS NULL');
        
        if ($pkm_id !== 'super') {
            $builderArtikel->where('trn_artikel.pkm_id', $pkm_id);
            $builderUser->where('sys_users.pkm_id', $pkm_id);
        }
        
        // 1. Total Pembaca
        $qPembaca = clone $builderArtikel;
        $qPembaca->selectSum('jumlah_tayang');
        $totalPembaca = $qPembaca->get()->getRow()->jumlah_tayang ?? 0;
        
        // 2. Artikel Aktif
        $qAktif = clone $builderArtikel;
        $qAktif->where('status', 'Ditayangkan');
        $artikelAktif = $qAktif->countAllResults();
        
        // 3. Langganan Baru (Pengguna Sistem)
        $langgananBaru = clone $builderUser;
        $totalPengguna = $langgananBaru->countAllResults();
        
        // 4. Menunggu Moderasi
        $qModerasi = clone $builderArtikel;
        $qModerasi->where('status', 'Draf');
        $menungguModerasi = $qModerasi->countAllResults();
        
        // 5. Berita Terpopuler
        $qPopuler = clone $builderArtikel;
        $qPopuler->orderBy('jumlah_tayang', 'DESC');
        $beritaPopuler = $qPopuler->get(3)->getResultArray();
        
        $qTerkini = clone $builderArtikel;
        $qTerkini->select('trn_artikel.*, sys_users.nama_publik as penulis_nama');
        $qTerkini->join('sys_users', 'sys_users.user_id = trn_artikel.user_id', 'left');
        $qTerkini->orderBy('trn_artikel.updated_at', 'DESC');
        $aktivitasTerkini = $qTerkini->get(3)->getResultArray();

        // 7. Log Antrian
        $logAntrianModel = new LogAntrianModel();
        $builderLog = $logAntrianModel->builder();
        if ($pkm_id !== 'super') {
            $builderLog->where('pkm_id', $pkm_id);
        }
        $builderLog->orderBy('tanggal', 'DESC')->orderBy('updated_at', 'DESC');
        $logAntrian = $builderLog->get(10)->getResultArray();

        $data = [
            'title' => 'Dashboard Admin - ' . (tenant()->pkm_nama ?? 'Super Admin'),
            'totalPembaca' => $totalPembaca,
            'artikelAktif' => $artikelAktif,
            'totalPengguna' => $totalPengguna,
            'menungguModerasi' => $menungguModerasi,
            'beritaPopuler' => $beritaPopuler,
            'aktivitasTerkini' => $aktivitasTerkini,
            'logAntrian' => $logAntrian
        ];
        
        return view('admin/dashboard', $data);
    }
}
