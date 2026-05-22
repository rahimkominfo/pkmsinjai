<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseAdminController
{
    protected $artikelModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel  = new ArtikelModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id; // Dummy tenant ID

        $data = [
            'title'   => 'Manajemen Artikel',
            'artikel' => $this->artikelModel->getArtikelWithAuthor($pkm_id)
        ];

        return view('admin/artikel/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'    => 'Tambah Artikel',
            'kategori' => $this->kategoriModel->where('pkm_id', $pkm_id)->findAll()
        ];
        
        return view('admin/artikel/form', $data);
    }

    public function store()
    {
        $rules = [
            'judul'  => 'required|min_length[5]',
            'konten' => 'required|min_length[10]',
            'status' => 'required|in_list[Draf,Ditayangkan,Diarsipkan]',
            'gambar_utama' => 'uploaded[gambar_utama]|is_image[gambar_utama]|mime_in[gambar_utama,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_utama,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;
        $user_id = 1; // Dummy session user_id
        
        helper('text');
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        
        // Cek unik slug
        $count = $this->artikelModel->where('slug', $slug)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        // Handle Upload Gambar
        $fileGambar = $this->request->getFile('gambar_utama');
        $namaGambar = null;
        
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $pkm_slug = tenant()->pkm_slug;
            $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/artikel/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $namaGambar = $fileGambar->getRandomName();
            $namaGambarWebp = pathinfo($namaGambar, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileGambar->getTempName())
                ->save($uploadPath . $namaGambarWebp, 80);
            
            $namaGambar = $namaGambarWebp;
        }

        $dataInsert = [
            'pkm_id'            => $pkm_id,
            'judul'             => $judul,
            'slug'              => $slug,
            'konten'            => $this->request->getPost('konten'),
            'abstrak'           => $this->request->getPost('abstrak'),
            'user_id'           => $user_id,
            'status'            => $this->request->getPost('status'),
            'tanggal_publikasi' => date('Y-m-d H:i:s')
        ];

        if ($namaGambar) {
            $dataInsert['gambar_utama'] = 'uploads/' . tenant()->pkm_slug . '/artikel/' . $namaGambar;
        }

        $artikel_id = $this->artikelModel->insert($dataInsert, true);

        // Handle Kategori
        $kategori_ids = $this->request->getPost('kategori_id'); // array
        if (!empty($kategori_ids)) {
            $this->artikelModel->syncCategories($artikel_id, $pkm_id, $kategori_ids);
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pkm_id = tenant()->pkm_id;
        $artikel = $this->artikelModel->find($id);

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan');
        }

        $data = [
            'title'           => 'Edit Artikel',
            'artikel'         => $artikel,
            'kategori'        => $this->kategoriModel->where('pkm_id', $pkm_id)->findAll(),
            'artikel_kategori'=> array_column($this->artikelModel->getCategories($id), 'kategori_id')
        ];

        return view('admin/artikel/form', $data);
    }

    public function update($id)
    {
        $artikel = $this->artikelModel->find($id);
        
        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan');
        }

        $rules = [
            'judul'  => 'required|min_length[5]',
            'konten' => 'required|min_length[10]',
            'status' => 'required|in_list[Draf,Ditayangkan,Diarsipkan]'
        ];

        // Validasi gambar jika ada yang diupload
        if ($this->request->getFile('gambar_utama')->isValid()) {
            $rules['gambar_utama'] = 'is_image[gambar_utama]|mime_in[gambar_utama,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_utama,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;
        helper('text');
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        
        // Ensure unique slug (if changed)
        if ($slug !== $artikel['slug']) {
            $count = $this->artikelModel->where('slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $updateData = [
            'judul'   => $judul,
            'slug'    => $slug,
            'konten'  => $this->request->getPost('konten'),
            'abstrak' => $this->request->getPost('abstrak'),
            'status'  => $this->request->getPost('status')
        ];

        // Handle Upload Gambar
        $fileGambar = $this->request->getFile('gambar_utama');
        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $pkm_slug = tenant()->pkm_slug;
            $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/artikel/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $namaGambar = $fileGambar->getRandomName();
            $namaGambarWebp = pathinfo($namaGambar, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileGambar->getTempName())
                ->save($uploadPath . $namaGambarWebp, 80);
            
            $updateData['gambar_utama'] = 'uploads/' . $pkm_slug . '/artikel/' . $namaGambarWebp;
        }

        $this->artikelModel->update($id, $updateData);

        // Handle Kategori
        $kategori_ids = $this->request->getPost('kategori_id'); // array
        $this->artikelModel->syncCategories($id, $pkm_id, empty($kategori_ids) ? [] : $kategori_ids);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->artikelModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('error', 'Gagal menghapus artikel.');
    }
}
