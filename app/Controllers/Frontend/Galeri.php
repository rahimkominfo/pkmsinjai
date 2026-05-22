<?php

namespace App\Controllers\Frontend;

class Galeri extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $galeriModel = new \App\Models\GaleriModel();
        $gambarModel = new \App\Models\GaleriGambarModel();

        $listGaleri = $galeriModel->getGaleriWithCount($pkm_id);
        
        // Fetch images for each gallery
        foreach ($listGaleri as &$galeri) {
            $galeri['images'] = $gambarModel->where('galeri_id', $galeri['galeri_id'])
                                            ->findAll();
        }

        $data = [
            'title' => 'Galeri Foto - ' . tenant()->pkm_nama,
            'list_galeri' => $listGaleri
        ];
        return view('frontend/galeri/index', $data);
    }
}
