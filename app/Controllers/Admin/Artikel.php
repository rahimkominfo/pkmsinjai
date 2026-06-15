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
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');
        
        $data = [
            'title'   => 'Manajemen Artikel',
        ];

        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['artikel'] = $this->artikelModel->getArtikelWithAuthor($filter_pkm_id);

        return view('admin/artikel/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'    => 'Tambah Artikel',
            'kategori' => $pkm_id === 'super' ? $this->kategoriModel->findAll() : $this->kategoriModel->where('pkm_id', $pkm_id)->findAll()
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/artikel/form', $data);
    }

    public function store()
    {
        if ($this->request->getMethod() === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            return redirect()->back()->withInput()->with('errors', ['Ukuran total data/file yang diunggah terlalu besar melebihi batas server (' . ini_get('post_max_size') . '). Silakan kompres ukuran gambar Anda.']);
        }

        $sumberGambar = $this->request->getPost('sumber_gambar');

        $rules = [
            'judul'             => 'required|min_length[5]',
            'konten'            => 'required|min_length[10]',
            'status'            => 'required|in_list[Draf,Ditayangkan,Diarsipkan]',
            'tanggal_publikasi' => 'permit_empty|valid_date[Y-m-d\TH:i]'
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if ($sumberGambar === 'upload') {
            $rules['gambar_utama'] = 'uploaded[gambar_utama]|is_image[gambar_utama]|mime_in[gambar_utama,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_utama,2048]';
        } else {
            $rules['gambar_utama_link'] = 'required|valid_url';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }
        $user_id = session()->get('user_id');
        
        helper('text');
        $judul = $this->request->getPost('judul');
        $slug = url_title($judul, '-', true);
        
        // Cek unik slug
        $count = $this->artikelModel->where('slug', $slug)->countAllResults();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        // Handle Gambar Utama
        $gambarUrlFinal = null;
        if ($sumberGambar === 'upload') {
            $fileGambar = $this->request->getFile('gambar_utama');
            if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
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

                $namaGambar = $fileGambar->getRandomName();
                $namaGambarWebp = pathinfo($namaGambar, PATHINFO_FILENAME) . '.webp';
                
                \Config\Services::image()
                    ->withFile($fileGambar->getTempName())
                    ->save($uploadPath . $namaGambarWebp, 80);
                
                $mediaPath = 'uploads/' . $pkm_slug . '/media/' . $namaGambarWebp;
                $gambarUrlFinal = $mediaPath;

                // Simpan ke tabel media
                $mediaModel = new \App\Models\MediaModel();
                $mediaModel->insert([
                    'pkm_id'    => $pkm_id,
                    'nama_file' => $fileGambar->getClientName(),
                    'url_file'  => $gambarUrlFinal,
                    'tipe_file' => 'image/webp',
                    'user_id'   => session()->get('user_id')
                ]);
            }
        } else {
            $gambarUrlFinal = $this->request->getPost('gambar_utama_link');
        }

        $tglPublikasi = $this->request->getPost('tanggal_publikasi');
        if (!empty($tglPublikasi)) {
            $tglPublikasi = str_replace('T', ' ', $tglPublikasi) . ':00';
        }

        $dataInsert = [
            'pkm_id'            => $pkm_id,
            'judul'             => $judul,
            'slug'              => $slug,
            'konten'            => $this->request->getPost('konten'),
            'abstrak'           => $this->request->getPost('abstrak'),
            'user_id'           => $user_id,
            'status'            => $this->request->getPost('status'),
            'tanggal_publikasi' => $tglPublikasi ?: date('Y-m-d H:i:s')
        ];

        if ($gambarUrlFinal) {
            $dataInsert['gambar_utama'] = $gambarUrlFinal;
        }

        $artikel_id = $this->artikelModel->insert($dataInsert, true);

        // Handle Kategori
        $kategori_ids = $this->request->getPost('kategori_id'); // array
        if (!empty($kategori_ids)) {
            $this->artikelModel->syncCategories($artikel_id, $pkm_id, $kategori_ids);
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->artikelModel->where('artikel_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $artikel = $query->first();

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $artikel['artikel_id'];
        $data = [
            'title'           => 'Edit Artikel',
            'artikel'         => $artikel,
            'kategori'        => $pkm_id === 'super' ? $this->kategoriModel->findAll() : $this->kategoriModel->where('pkm_id', $pkm_id)->findAll(),
            'artikel_kategori'=> array_column($this->artikelModel->getCategories($id), 'kategori_id')
        ];

        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/artikel/form', $data);
    }

    public function update($uuid)
    {
        if ($this->request->getMethod() === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
            return redirect()->back()->withInput()->with('errors', ['Ukuran total data/file yang diunggah terlalu besar melebihi batas server (' . ini_get('post_max_size') . '). Silakan kompres ukuran gambar Anda.']);
        }

        $pkm_id = tenant()->pkm_id;
        $query = $this->artikelModel->where('artikel_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $artikel = $query->first();
        
        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Artikel tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $artikel['artikel_id'];
        $sumberGambar = $this->request->getPost('sumber_gambar');

        $rules = [
            'judul'             => 'required|min_length[5]',
            'konten'            => 'required|min_length[10]',
            'status'            => 'required|in_list[Draf,Ditayangkan,Diarsipkan]',
            'tanggal_publikasi' => 'permit_empty|valid_date[Y-m-d\TH:i]'
        ];

        if ($pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if ($sumberGambar === 'upload' && $this->request->getFile('gambar_utama')->isValid()) {
            $rules['gambar_utama'] = 'is_image[gambar_utama]|mime_in[gambar_utama,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar_utama,2048]';
        } elseif ($sumberGambar === 'link' && !empty($this->request->getPost('gambar_utama_link'))) {
            $rules['gambar_utama_link'] = 'valid_url';
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
        $slug = url_title($judul, '-', true);
        
        // Ensure unique slug (if changed)
        if ($slug !== $artikel['slug']) {
            $count = $this->artikelModel->where('slug', $slug)->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        }

        $tglPublikasi = $this->request->getPost('tanggal_publikasi');
        if (!empty($tglPublikasi)) {
            $tglPublikasi = str_replace('T', ' ', $tglPublikasi) . ':00';
        }

        $updateData = [
            'judul'             => $judul,
            'slug'              => $slug,
            'konten'            => $this->request->getPost('konten'),
            'abstrak'           => $this->request->getPost('abstrak'),
            'status'            => $this->request->getPost('status'),
            'tanggal_publikasi' => $tglPublikasi ?: date('Y-m-d H:i:s')
        ];
        
        if ($pkm_id === 'super') {
            $updateData['pkm_id'] = $target_pkm_id;
        }

        // Handle Gambar Utama
        if ($sumberGambar === 'upload') {
            $fileGambar = $this->request->getFile('gambar_utama');
            if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
                $pkm_slug = tenant()->pkm_slug;
                if ($pkm_id === 'super') {
                    $pkmModel = new \App\Models\PkmModel();
                    $selectedPkm = $pkmModel->find($target_pkm_id);
                    if ($selectedPkm) {
                        $pkm_slug = $selectedPkm['pkm_slug'];
                    }
                }
                
                $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/media/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $namaGambar = $fileGambar->getRandomName();
                $namaGambarWebp = pathinfo($namaGambar, PATHINFO_FILENAME) . '.webp';
                
                \Config\Services::image()
                    ->withFile($fileGambar->getTempName())
                    ->save($uploadPath . $namaGambarWebp, 80);
                
                $mediaPath = 'uploads/' . $pkm_slug . '/media/' . $namaGambarWebp;
                $gambarUrlFinal = $mediaPath;
                $updateData['gambar_utama'] = $gambarUrlFinal;

                // Simpan ke tabel media
                $mediaModel = new \App\Models\MediaModel();
                $mediaModel->insert([
                    'pkm_id'    => $target_pkm_id,
                    'nama_file' => $fileGambar->getClientName(),
                    'url_file'  => $gambarUrlFinal,
                    'tipe_file' => 'image/webp',
                    'user_id'   => session()->get('user_id')
                ]);
            }
        } elseif ($sumberGambar === 'link' && !empty($this->request->getPost('gambar_utama_link'))) {
            $updateData['gambar_utama'] = $this->request->getPost('gambar_utama_link');
        }

        $this->artikelModel->update($id, $updateData);

        // Handle Kategori
        $kategori_ids = $this->request->getPost('kategori_id'); // array
        $this->artikelModel->syncCategories($id, $target_pkm_id, empty($kategori_ids) ? [] : $kategori_ids);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil diupdate.');
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->artikelModel->where('artikel_uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $artikel = $query->first();

        if ($artikel && $this->artikelModel->delete($artikel['artikel_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('message', 'Artikel berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/artikel')->with('error', 'Gagal menghapus artikel atau Anda tidak memiliki akses.');
    }
}
