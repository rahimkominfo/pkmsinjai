<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AntrianModel;

class Antrian extends BaseAdminController
{
    protected $antrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'   => 'Manajemen Antrian',
            'antrian' => $this->antrianModel->where('pkm_id', $pkm_id)->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->findAll()
        ];

        return view('admin/antrian/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Antrian'
        ];
        return view('admin/antrian/form', $data);
    }

    public function store()
    {
        $rules = [
            'title'   => 'required|min_length[3]',
            'loket'   => 'required',
            'nomor'   => 'required',
            'petugas' => 'required',
            'status'  => 'required|in_list[menunggu,dilayani,selesai,batal]',
            'tanggal' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;

        $this->antrianModel->insert([
            'pkm_id'  => $pkm_id,
            'title'   => $this->request->getPost('title'),
            'loket'   => $this->request->getPost('loket'),
            'nomor'   => $this->request->getPost('nomor'),
            'petugas' => $this->request->getPost('petugas'),
            'status'  => $this->request->getPost('status'),
            'tanggal' => $this->request->getPost('tanggal'),
            'color'   => $this->request->getPost('color'),
            'icon'    => $this->request->getPost('icon')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $antrian = $this->antrianModel->find($id);

        if (!$antrian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data antrian tidak ditemukan');
        }

        $data = [
            'title'   => 'Edit Antrian',
            'antrian' => $antrian
        ];

        return view('admin/antrian/form', $data);
    }

    public function update($id)
    {
        $antrian = $this->antrianModel->find($id);
        
        if (!$antrian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data antrian tidak ditemukan');
        }

        $rules = [
            'title'   => 'required|min_length[3]',
            'loket'   => 'required',
            'nomor'   => 'required',
            'petugas' => 'required',
            'status'  => 'required|in_list[menunggu,dilayani,selesai,batal]',
            'tanggal' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->antrianModel->update($id, [
            'title'   => $this->request->getPost('title'),
            'loket'   => $this->request->getPost('loket'),
            'nomor'   => $this->request->getPost('nomor'),
            'petugas' => $this->request->getPost('petugas'),
            'status'  => $this->request->getPost('status'),
            'tanggal' => $this->request->getPost('tanggal'),
            'color'   => $this->request->getPost('color'),
            'icon'    => $this->request->getPost('icon')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->antrianModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('error', 'Gagal menghapus antrian.');
    }
}
