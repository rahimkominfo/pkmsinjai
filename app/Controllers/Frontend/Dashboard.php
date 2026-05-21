<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        // For multi-tenant, typically pkm_id is obtained from session/middleware.
        // Hardcoding to 1 for now as per single tenant fallback or adjust as needed.
        $pkm_id = 1; 

        $artikelModel = new \App\Models\ArtikelModel();
        $galeriModel = new \App\Models\GaleriModel();

        $data = [
            'title' => 'PKM Balangnipa - Beranda',
            'hero_artikel' => $artikelModel->getPublished($pkm_id, 1),
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 4), // 1 featured + 3 list
            'galeri_terbaru' => $galeriModel->getGaleriWithCount($pkm_id)
        ];
        return view('frontend/dashboard/index', $data);
    }
}
