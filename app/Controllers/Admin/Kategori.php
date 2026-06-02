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
        $pkm_id = tenant()->pkm_id; // Sesuaikan dengan id tenant

        $data = [
            'title'    => 'Manajemen Kategori',
            'kategori' => $this->kategoriModel->getKategoriWithInduk($pkm_id)
        ];

        return view('admin/kategori/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'           => 'Tambah Kategori',
            'parent_kategori' => $this->kategoriModel->where('pkm_id', $pkm_id)->findAll()
        ];
        return view('admin/kategori/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]|is_unique[mst_kategori.nama]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        helper('text');
        $nama = $this->request->getPost('nama');
        $slug = url_title($nama, '-', true);
        
        // Ensure unique slug
        $count = $this->kategoriModel->where('slug', $slug)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        $kategori_induk_id = $this->request->getPost('kategori_induk_id');

        $this->kategoriModel->insert([
            'pkm_id'            => tenant()->pkm_id,
            'nama'              => $nama,
            'slug'              => $slug,
            'kategori_induk_id' => empty($kategori_induk_id) ? null : $kategori_induk_id
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pkm_id = tenant()->pkm_id;
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        $data = [
            'title'           => 'Edit Kategori',
            'kategori'        => $kategori,
            'parent_kategori' => $this->kategoriModel->where('pkm_id', $pkm_id)
                                                     ->where('kategori_id !=', $id) // tidak boleh memilih diri sendiri sebagai parent
                                                     ->findAll()
        ];

        return view('admin/kategori/form', $data);
    }

    public function update($id)
    {
        $kategori = $this->kategoriModel->find($id);
        
        if (!$kategori) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        $rules = [
            'nama' => "required|min_length[3]|is_unique[mst_kategori.nama,kategori_id,{$id}]"
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        helper('text');
        $nama = $this->request->getPost('nama');
        $slug = url_title($nama, '-', true);
        
        // Ensure unique slug (if changed)
        if ($slug !== $kategori['slug']) {
            $count = $this->kategoriModel->where('slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $kategori_induk_id = $this->request->getPost('kategori_induk_id');

        $this->kategoriModel->update($id, [
            'nama'              => $nama,
            'slug'              => $slug,
            'kategori_induk_id' => empty($kategori_induk_id) ? null : $kategori_induk_id
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil diupdate.');
    }

    public function delete($id)
    {
        // Opsional: periksa jika ada sub-kategori atau artikel yang memakai kategori ini
        if ($this->kategoriModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('message', 'Kategori berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/kategori')->with('error', 'Gagal menghapus kategori.');
    }
}
