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
        $galeriGambarModel = new \App\Models\GaleriGambarModel();

        $galeri_terbaru = $galeriModel->getGaleriWithCount($pkm_id);
        foreach ($galeri_terbaru as &$gal) {
            $gal['photos'] = $galeriGambarModel->where('galeri_id', $gal['galeri_id'])->findAll();
        }

        $data = [
            'title' => tenant()->pkm_nama . ' - Beranda',
            'hero_artikel' => $artikelModel->getPublished($pkm_id, 3), // Fetch 3 for carousel
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 4), // 1 featured + 3 list
            'galeri_terbaru' => $galeri_terbaru
        ];
        return view('frontend/dashboard/index', $data);
    }
}
