<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\GaleriGambarModel;

class Galeri extends BaseAdminController
{
    protected $galeriModel;
    protected $gambarModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        $this->gambarModel = new GaleriGambarModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'  => 'Manajemen Galeri',
            'galeri' => $this->galeriModel->getGaleriWithCount($pkm_id)
        ];

        return view('admin/galeri/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Galeri'
        ];
        return view('admin/galeri/form', $data);
    }

    public function store()
    {
        $rules = [
            'judul'      => 'required|min_length[3]',
            'sampul_url' => 'uploaded[sampul_url]|is_image[sampul_url]|mime_in[sampul_url,image/jpg,image/jpeg,image/png,image/webp]|max_size[sampul_url,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;
        $pkm_slug = tenant()->pkm_slug;
        
        // Ensure directory exists
        $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/galeri/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        // Upload Sampul
        $fileSampul = $this->request->getFile('sampul_url');
        $namaSampul = $fileSampul->getRandomName();
        $namaSampulWebp = pathinfo($namaSampul, PATHINFO_FILENAME) . '.webp';
        
        // Move and convert to webp
        \Config\Services::image()
            ->withFile($fileSampul->getTempName())
            ->save($uploadPath . $namaSampulWebp, 80);

        $galeri_id = $this->galeriModel->insert([
            'pkm_id'     => $pkm_id,
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'sampul_url' => 'uploads/' . $pkm_slug . '/galeri/' . $namaSampulWebp
        ], true);

        // Upload Foto-foto Tambahan (Multiple)
        $files = $this->request->getFiles();
        if (isset($files['foto'])) {
            foreach ($files['foto'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $newNameWebp = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
                    
                    \Config\Services::image()
                        ->withFile($img->getTempName())
                        ->save($uploadPath . $newNameWebp, 80);
                    
                    $this->gambarModel->insert([
                        'galeri_id'  => $galeri_id,
                        'pkm_id'     => $pkm_id,
                        'gambar_url' => 'uploads/' . $pkm_slug . '/galeri/' . $newNameWebp,
                        'caption'    => null
                    ]);
                }
            }
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/galeri')->with('message', 'Galeri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = $this->galeriModel->find($id);

        if (!$galeri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Galeri tidak ditemukan');
        }

        $data = [
            'title'  => 'Edit Galeri',
            'galeri' => $galeri,
            'foto'   => $this->gambarModel->where('galeri_id', $id)->findAll()
        ];

        return view('admin/galeri/form', $data);
    }

    public function update($id)
    {
        $galeri = $this->galeriModel->find($id);
        
        if (!$galeri) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Galeri tidak ditemukan');
        }

        $rules = [
            'judul' => 'required|min_length[3]'
        ];

        // Jika upload sampul baru
        if ($this->request->getFile('sampul_url')->isValid()) {
            $rules['sampul_url'] = 'is_image[sampul_url]|mime_in[sampul_url,image/jpg,image/jpeg,image/png,image/webp]|max_size[sampul_url,2048]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $pkm_slug = tenant()->pkm_slug;
        $uploadPath = FCPATH . 'uploads/' . $pkm_slug . '/galeri/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        if ($this->request->getFile('sampul_url')->isValid()) {
            $fileSampul = $this->request->getFile('sampul_url');
            $namaSampul = $fileSampul->getRandomName();
            $namaSampulWebp = pathinfo($namaSampul, PATHINFO_FILENAME) . '.webp';
            
            \Config\Services::image()
                ->withFile($fileSampul->getTempName())
                ->save($uploadPath . $namaSampulWebp, 80);
            
            $updateData['sampul_url'] = 'uploads/' . $pkm_slug . '/galeri/' . $namaSampulWebp;
        }

        $this->galeriModel->update($id, $updateData);

        // Tambah Foto Baru (append)
        $files = $this->request->getFiles();
        if (isset($files['foto'])) {
            foreach ($files['foto'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $newNameWebp = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
                    
                    \Config\Services::image()
                        ->withFile($img->getTempName())
                        ->save($uploadPath . $newNameWebp, 80);
                    
                    $this->gambarModel->insert([
                        'galeri_id'  => $id,
                        'pkm_id'     => tenant()->pkm_id,
                        'gambar_url' => 'uploads/' . $pkm_slug . '/galeri/' . $newNameWebp,
                        'caption'    => null
                    ]);
                }
            }
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/galeri')->with('message', 'Galeri berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->galeriModel->delete($id)) {
            // Note: Foto-foto tidak dihapus fisik demi history (atau bisa gunakan event model untuk menghapus file fisik).
            return redirect()->to('admin/' . tenant()->pkm_slug . '/galeri')->with('message', 'Galeri berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/galeri')->with('error', 'Gagal menghapus galeri.');
    }

    public function delete_foto($foto_id)
    {
        $foto = $this->gambarModel->find($foto_id);
        if ($foto) {
            $this->gambarModel->delete($foto_id);
            // Optional: unlink file fisik
            // if (file_exists(FCPATH . $foto['gambar_url'])) { unlink(FCPATH . $foto['gambar_url']); }
        }
        return redirect()->back()->with('message', 'Foto berhasil dihapus dari galeri.');
    }
}
