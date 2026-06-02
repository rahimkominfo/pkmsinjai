<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PkmModel;

class Pengaturan extends BaseAdminController
{
    protected $pkmModel;

    public function __construct()
    {
        $this->pkmModel = new PkmModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;

        if ($pkm_id === 'super') {
            $pkms = $this->pkmModel->findAll();
        } else {
            $pkms = $this->pkmModel->where('pkm_id', $pkm_id)->findAll();
        }

        $data = [
            'title' => 'Daftar Identitas PKM (Tenant)',
            'pkms'  => $pkms
        ];

        return view('admin/pengaturan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Identitas PKM'
        ];
        return view('admin/pengaturan/form', $data);
    }

    public function store()
    {
        $rules = [
            'pkm_nama' => 'required|min_length[3]'
        ];

        if ($this->request->getFile('logo')->isValid()) {
            $rules['logo'] = 'is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]|max_size[logo,1024]';
        }
        
        if ($this->request->getFile('header_img')->isValid()) {
            $rules['header_img'] = 'is_image[header_img]|mime_in[header_img,image/jpg,image/jpeg,image/png,image/webp]|max_size[header_img,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        helper('text');
        $nama = $this->request->getPost('pkm_nama');
        $slug = url_title($nama, '-', true);
        
        $count = $this->pkmModel->where('pkm_slug', $slug)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $insertData = [
            'pkm_nama'      => $nama,
            'pkm_slug'      => $slug,
            'primary_color' => $this->request->getPost('primary_color') ?: '#006c4a',
            'on_primary_color' => $this->request->getPost('on_primary_color') ?: '#ffffff',
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'telepon'       => $this->request->getPost('telepon'),
            'facebook'      => $this->request->getPost('facebook'),
            'instagram'     => $this->request->getPost('instagram'),
            'youtube'       => $this->request->getPost('youtube'),
            'google_maps'   => $this->request->getPost('google_maps'),
        ];

        $uploadPath = FCPATH . 'uploads/' . $slug . '/pkm/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        // Handle File Uploads
        $fileLogo = $this->request->getFile('logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $namaLogoWebp = pathinfo($namaLogo, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileLogo->getTempName())
                ->save($uploadPath . $namaLogoWebp, 80);
            
            $insertData['logo'] = 'uploads/' . $slug . '/pkm/' . $namaLogoWebp;
        }

        $fileHeader = $this->request->getFile('header_img');
        if ($fileHeader && $fileHeader->isValid() && !$fileHeader->hasMoved()) {
            $namaHeader = $fileHeader->getRandomName();
            $namaHeaderWebp = pathinfo($namaHeader, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileHeader->getTempName())
                ->save($uploadPath . $namaHeaderWebp, 80);
            
            $insertData['header_img'] = 'uploads/' . $slug . '/pkm/' . $namaHeaderWebp;
        }

        $this->pkmModel->insert($insertData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengaturan')->with('message', 'Identitas PKM berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pkm = $this->pkmModel->find($id);

        if (!$pkm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Identitas PKM tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Identitas PKM',
            'pkm'   => $pkm
        ];

        return view('admin/pengaturan/form', $data);
    }

    public function update($id)
    {
        $pkm = $this->pkmModel->find($id);
        
        if (!$pkm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Identitas PKM tidak ditemukan');
        }

        $rules = [
            'pkm_nama' => 'required|min_length[3]'
        ];

        if ($this->request->getFile('logo')->isValid()) {
            $rules['logo'] = 'is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]|max_size[logo,1024]';
        }
        
        if ($this->request->getFile('header_img')->isValid()) {
            $rules['header_img'] = 'is_image[header_img]|mime_in[header_img,image/jpg,image/jpeg,image/png,image/webp]|max_size[header_img,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        helper('text');
        $nama = $this->request->getPost('pkm_nama');
        $slug = url_title($nama, '-', true);
        
        if ($slug !== $pkm['pkm_slug']) {
            $count = $this->pkmModel->where('pkm_slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $updateData = [
            'pkm_nama'      => $nama,
            'pkm_slug'      => $slug,
            'primary_color' => $this->request->getPost('primary_color'),
            'on_primary_color' => $this->request->getPost('on_primary_color'),
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'telepon'       => $this->request->getPost('telepon'),
            'facebook'      => $this->request->getPost('facebook'),
            'instagram'     => $this->request->getPost('instagram'),
            'youtube'       => $this->request->getPost('youtube'),
            'google_maps'   => $this->request->getPost('google_maps'),
        ];

        $uploadPath = FCPATH . 'uploads/' . $slug . '/pkm/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        // Handle File Uploads
        $fileLogo = $this->request->getFile('logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $namaLogo = $fileLogo->getRandomName();
            $namaLogoWebp = pathinfo($namaLogo, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileLogo->getTempName())
                ->save($uploadPath . $namaLogoWebp, 80);
            
            $updateData['logo'] = 'uploads/' . $slug . '/pkm/' . $namaLogoWebp;
        }

        $fileHeader = $this->request->getFile('header_img');
        if ($fileHeader && $fileHeader->isValid() && !$fileHeader->hasMoved()) {
            $namaHeader = $fileHeader->getRandomName();
            $namaHeaderWebp = pathinfo($namaHeader, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileHeader->getTempName())
                ->save($uploadPath . $namaHeaderWebp, 80);
            
            $updateData['header_img'] = 'uploads/' . $slug . '/pkm/' . $namaHeaderWebp;
        }

        $this->pkmModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengaturan')->with('message', 'Identitas PKM berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->pkmModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/pengaturan')->with('message', 'Identitas PKM berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengaturan')->with('error', 'Gagal menghapus PKM.');
    }
}
