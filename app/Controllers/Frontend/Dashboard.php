<?php

namespace App\Controllers\Frontend;

class Dashboard extends BaseTenantController
{
    public function index()
    {
        // Ambil pkm_id dari helper tenant global (sudah di-set otomatis di BaseTenantController)
        $pkm_id = tenant()->pkm_id;

        $artikelModel = new \App\Models\ArtikelModel();
        $galeriModel = new \App\Models\GaleriModel();

        $data = [
            'title' => tenant()->pkm_nama . ' - Beranda',
            'hero_artikel' => $artikelModel->getPublished($pkm_id, 1),
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 4), // 1 featured + 3 list
            'galeri_terbaru' => $galeriModel->getGaleriWithCount($pkm_id)
        ];
        return view('frontend/dashboard/index', $data);
    }
}
