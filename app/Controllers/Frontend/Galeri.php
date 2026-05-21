<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Galeri extends BaseController
{
    public function index(): string
    {
        $pkm_id = 1;
        $galeriModel = new \App\Models\GaleriModel();
        $gambarModel = new \App\Models\GaleriGambarModel();

        $listGaleri = $galeriModel->getGaleriWithCount($pkm_id);
        
        // Fetch images for each gallery
        foreach ($listGaleri as &$galeri) {
            $galeri['images'] = $gambarModel->where('galeri_id', $galeri['galeri_id'])
                                            ->findAll();
        }

        $data = [
            'title' => 'Galeri Foto - PKM Balangnipa',
            'list_galeri' => $listGaleri
        ];
        return view('frontend/galeri/index', $data);
    }
}
