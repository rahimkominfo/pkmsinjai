<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseAdminController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');

        $data = [
            'title'    => 'Manajemen Kategori',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['kategori'] = $this->kategoriModel->getKategoriWithInduk($filter_pkm_id);

        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'           => 'Tambah Kategori',
            'parent_kategori' => $pkm_id === 'super' ? $this->kategoriModel->findAll() : $this->kategoriModel->where('pkm_id', $pkm_id)->findAll()
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/kategori/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]'
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
        $nama = $this->request->getPost('nama');
        
        // Cek nama unik per PKM
        if ($this->kategoriModel->where('pkm_id', $pkm_id)->where('nama', $nama)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', ['nama' => 'The nama field must contain a unique value.']);
        }

        $slug = url_title($nama, '-', true);
        
        // Ensure unique slug per PKM
        $count = $this->kategoriModel->where('slug', $slug)->where('pkm_id', $pkm_id)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $kategori_induk_id = $this->request->getPost('kategori_induk_id');

        $this->kategoriModel->insert([
            'pkm_id'            => $pkm_id,
            'nama'              => $nama,
            'slug'              => $slug,
            'kategori_induk_id' => empty($kategori_induk_id) ? null : $kategori_induk_id
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->kategoriModel->where('kategori_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $kategori = $query->first();

        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $kategori['kategori_id'];
        $parent_query = $this->kategoriModel->where('kategori_id !=', $id);
        if ($pkm_id !== 'super') {
            $parent_query->where('pkm_id', $pkm_id);
        }

        $data = [
            'title'           => 'Edit Kategori',
            'kategori'        => $kategori,
            'parent_kategori' => $parent_query->findAll()
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/kategori/form', $data);
    }

    public function update($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->kategoriModel->where('kategori_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $kategori = $query->first();
        
        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $kategori['kategori_id'];
        $rules = [
            'nama' => "required|min_length[3]"
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
        $nama = $this->request->getPost('nama');
        
        // Cek nama unik per PKM saat update
        if ($this->kategoriModel->where('pkm_id', $target_pkm_id)->where('nama', $nama)->where('kategori_id !=', $id)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', ['nama' => 'The nama field must contain a unique value.']);
        }

        $slug = url_title($nama, '-', true);
        
        // Ensure unique slug (if changed) per PKM
        if ($slug !== $kategori['slug']) {
            $count = $this->kategoriModel->where('slug', $slug)->where('pkm_id', $target_pkm_id)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $kategori_induk_id = $this->request->getPost('kategori_induk_id');

        $updateData = [
            'nama'              => $nama,
            'slug'              => $slug,
            'kategori_induk_id' => empty($kategori_induk_id) ? null : $kategori_induk_id
        ];
        
        if ($pkm_id === 'super') {
            $updateData['pkm_id'] = $target_pkm_id;
        }

        $this->kategoriModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil diupdate.');
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->kategoriModel->where('kategori_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $kategori = $query->first();

        if ($kategori && $this->kategoriModel->delete($kategori['kategori_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('error', 'Gagal menghapus kategori atau data tidak ditemukan/tidak memiliki akses.');
    }
}
