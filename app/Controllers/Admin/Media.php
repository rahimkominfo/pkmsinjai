<?php

namespace App\Controllers\Admin;

use App\Models\MediaModel;

class Media extends BaseAdminController
{
    protected $mediaModel;

    public function __construct()
    {
        $this->mediaModel = new MediaModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');
        
        $data = [
            'title' => 'Manajemen Media - ' . tenant()->pkm_nama,
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }
        
        $data['list_media'] = $this->mediaModel->getMediaList($filter_pkm_id);
        
        return view('admin/media/index', $data);
    }

    public function store()
    {
        $pkm_id = tenant()->pkm_id;

        $rules = [
            'file_media' => 'uploaded[file_media]|max_size[file_media,10240]|mime_in[file_media,image/jpg,image/jpeg,image/png,image/webp,application/pdf]',
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Gagal mengunggah file. Pastikan format valid, ukuran maksimal 10MB, dan form terisi lengkap.');
        }

        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }

        $file = $this->request->getFile('file_media');
        if ($file->isValid() && !$file->hasMoved()) {
            $pkm_slug = tenant()->pkm_slug;
            if (tenant()->pkm_id === 'super') {
                $pkmModel = new \App\Models\PkmModel();
                $selectedPkm = $pkmModel->find($pkm_id);
                if ($selectedPkm) {
                    $pkm_slug = $selectedPkm['pkm_slug'];
                }
            }
            
            $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/media/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $this->mediaModel->insert([
                'pkm_id'    => $pkm_id,
                'nama_file' => $file->getClientName(),
                'tipe_file' => $file->getClientMimeType(),
                'url_file'  => 'uploads/' . $pkm_slug . '/media/' . $newName,
                'user_id'   => session()->get('user_id')
            ]);

            return redirect()->back()->with('success', 'Media berhasil diunggah.');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunggah file.');
    }

    public function delete($id)
    {
        $pkm_id = tenant()->pkm_id;
        
        if ($pkm_id === 'super') {
            $media = $this->mediaModel->find($id);
        } else {
            $media = $this->mediaModel->where('pkm_id', $pkm_id)->find($id);
        }

        if ($media) {
            $this->mediaModel->delete($id);
            return redirect()->back()->with('success', 'Media berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Media tidak ditemukan.');
    }
}
