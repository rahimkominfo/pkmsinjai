<?php

namespace App\Controllers\Frontend;

use App\Models\PagesModel;

class Pages extends BaseTenantController
{
    public function detail($slug = null)
    {
        $pkm_id = tenant()->pkm_id;
        $pagesModel = new PagesModel();
        
        $page = $pagesModel->where('slug', $slug)
                           ->where('pkm_id', $pkm_id)
                           ->where('status', 'Diterbitkan')
                           ->first();
                           
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman tidak ditemukan.');
        }

        $data = [
            'title' => esc($page['judul']) . ' - ' . tenant()->pkm_nama,
            'page'  => $page
        ];
        
        return view('frontend/pages/detail', $data);
    }
}
