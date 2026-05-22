<?php

namespace App\Controllers\Frontend;

class Berita extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $artikelModel = new \App\Models\ArtikelModel();

        // simple pagination or just list all
        $data = [
            'title' => 'Berita Terkini - ' . tenant()->pkm_nama,
            'list_berita' => $artikelModel->getPublished($pkm_id)
        ];
        return view('frontend/berita/index', $data);
    }

    public function detail($slug = null)
    {
        $pkm_id = tenant()->pkm_id;
        $artikelModel = new \App\Models\ArtikelModel();
        
        $artikel = $artikelModel->getBySlug($slug, $pkm_id);
        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => esc($artikel['judul']) . ' - ' . tenant()->pkm_nama,
            'artikel' => $artikel,
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 3)
        ];
        return view('frontend/berita/detail', $data);
    }
}
