<?php

namespace App\Controllers\Frontend;

use App\Models\MstFlyerModel;

class Flyer extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $flyerModel = new MstFlyerModel();

        $data = [
            'title' => 'Media Promosi Kesehatan - ' . tenant()->pkm_nama,
            'flyers' => $flyerModel->where('pkm_id', $pkm_id)
                                   ->where('status', 'Aktif')
                                   ->orderBy('urutan', 'ASC')
                                   ->findAll()
        ];

        return view('frontend/flyer/index', $data);
    }

    public function detail($uuid = null)
    {
        $pkm_id = tenant()->pkm_id;
        $flyerModel = new MstFlyerModel();

        $flyer = $flyerModel->where('uuid', $uuid)
                            ->where('pkm_id', $pkm_id)
                            ->where('status', 'Aktif')
                            ->first();

        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Media promosi tidak ditemukan.');
        }

        $data = [
            'title' => esc($flyer['judul']) . ' - ' . tenant()->pkm_nama,
            'flyer' => $flyer,
            'other_flyers' => $flyerModel->where('pkm_id', $pkm_id)
                                         ->where('status', 'Aktif')
                                         ->where('uuid !=', $uuid)
                                         ->orderBy('urutan', 'ASC')
                                         ->limit(4)
                                         ->findAll()
        ];

        return view('frontend/flyer/detail', $data);
    }
}
