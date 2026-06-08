<?php

namespace App\Controllers\Frontend;

class Berita extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $artikelModel = new \App\Models\ArtikelModel();

        $search = $this->request->getGet('q');

        // simple pagination or just list all
        $data = [
            'title' => 'Berita Terkini - ' . tenant()->pkm_nama,
            'list_berita' => $artikelModel->getPublished($pkm_id, 0, $search),
            'searchQuery' => $search
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

        // Increment view count (jumlah_tayang) with session check
        $session = session();
        $viewed_articles = $session->get('viewed_articles') ?? [];

        if (!in_array($artikel['artikel_id'], $viewed_articles)) {
            $artikelModel->update($artikel['artikel_id'], ['jumlah_tayang' => $artikel['jumlah_tayang'] + 1]);
            $artikel['jumlah_tayang']++;
            
            $viewed_articles[] = $artikel['artikel_id'];
            $session->set('viewed_articles', $viewed_articles);
        }

        $data = [
            'title' => esc($artikel['judul']) . ' - ' . tenant()->pkm_nama,
            'artikel' => $artikel,
            'berita_terbaru' => $artikelModel->getPublished($pkm_id, 3),
            'berita_terpopuler' => $artikelModel->getPopular($pkm_id, 4)
        ];
        return view('frontend/berita/detail', $data);
    }
}
