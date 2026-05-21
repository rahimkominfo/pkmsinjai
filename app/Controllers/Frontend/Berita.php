<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Berita extends BaseController
{
    public function index(): string
    {
        $pkm_id = 1;
        $artikelModel = new \App\Models\ArtikelModel();

        // simple pagination or just list all
        $data = [
            'title' => 'Berita Terkini - PKM Balangnipa',
            'list_berita' => $artikelModel->getPublished($pkm_id)
        ];
        return view('frontend/berita/index', $data);
    }

    public function detail($slug = null)
    {
        $pkm_id = 1;
        $artikelModel = new \App\Models\ArtikelModel();
        
        $artikel = $artikelModel->getBySlug($slug, $pkm_id);
        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => esc($artikel['judul']) . ' - PKM Balangnipa',
            'artikel' => $artikel,
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 3)
        ];
        return view('frontend/berita/detail', $data);
    }
}
