<?php

namespace App\Controllers\Admin;

use App\Models\PagesModel;

class Pages extends BaseAdminController
{
    protected $pagesModel;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');

        $data = [
            'title' => 'Manajemen Halaman Statis',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['pages'] = $this->pagesModel->getPagesWithPkm($filter_pkm_id);

        return view('admin/pages/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title' => 'Tambah Halaman Statis',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/pages/form', $data);
    }

    public function store()
    {
        $rawKonten = $this->request->getPost('konten');
        // Decode base64 if it is obfuscated to bypass ModSecurity
        if ($this->isBase64($rawKonten)) {
            $rawKonten = base64_decode($rawKonten);
            $_POST['konten'] = $rawKonten; // Set back to POST for validation
        }

        $rules = [
            'judul'  => 'required|min_length[3]',
            'konten' => 'required',
            'status' => 'required|in_list[Draf,Diterbitkan]'
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }

        helper('text');
        $judul = $this->request->getPost('judul');

        // Cek judul unik per PKM
        if ($this->pagesModel->where('pkm_id', $pkm_id)->where('judul', $judul)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', ['judul' => 'The judul field must contain a unique value for this PKM.']);
        }

        $slug = url_title($judul, '-', true);
        
        // Ensure unique slug per PKM
        $count = $this->pagesModel->where('slug', $slug)->where('pkm_id', $pkm_id)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $this->pagesModel->insert([
            'pkm_id' => $pkm_id,
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => $rawKonten,
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pages')->with('message', 'Halaman statis berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->pagesModel->where('page_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $page = $query->first();

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman statis tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $data = [
            'title' => 'Edit Halaman Statis',
            'page'  => $page
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/pages/form', $data);
    }

    public function update($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->pagesModel->where('page_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $page = $query->first();
        
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman statis tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $rawKonten = $this->request->getPost('konten');
        // Decode base64 if it is obfuscated to bypass ModSecurity
        if ($this->isBase64($rawKonten)) {
            $rawKonten = base64_decode($rawKonten);
            $_POST['konten'] = $rawKonten; // Set back to POST for validation
        }

        $id = $page['page_id'];
        $rules = [
            'judul'  => "required|min_length[3]",
            'konten' => 'required',
            'status' => 'required|in_list[Draf,Diterbitkan]'
        ];
        
        if ($pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $target_pkm_id = $pkm_id;
        if ($pkm_id === 'super') {
            $target_pkm_id = $this->request->getPost('pkm_id');
        }

        helper('text');
        $judul = $this->request->getPost('judul');

        // Cek judul unik per PKM saat update
        if ($this->pagesModel->where('pkm_id', $target_pkm_id)->where('judul', $judul)->where('page_id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', ['judul' => 'The judul field must contain a unique value for this PKM.']);
        }

        $slug = url_title($judul, '-', true);
        
        // Ensure unique slug (if changed) per PKM
        if ($slug !== $page['slug'] || $target_pkm_id != $page['pkm_id']) {
            $count = $this->pagesModel->where('slug', $slug)->where('pkm_id', $target_pkm_id)->where('page_id !=', $id)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $updateData = [
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => $rawKonten,
            'status' => $this->request->getPost('status')
        ];
        
        if ($pkm_id === 'super') {
            $updateData['pkm_id'] = $target_pkm_id;
        }

        $this->pagesModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pages')->with('message', 'Halaman statis berhasil diupdate.');
    }

    private function isBase64($string)
    {
        if (!is_string($string)) return false;
        if (base64_encode(base64_decode($string, true)) === $string) return true;
        return false;
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->pagesModel->where('page_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $page = $query->first();

        if ($page && $this->pagesModel->delete($page['page_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/pages')->with('message', 'Halaman statis berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pages')->with('error', 'Gagal menghapus halaman statis atau data tidak ditemukan/tidak memiliki akses.');
    }
}
