<?php

namespace App\Controllers\Admin;

use App\Models\PeranModel;

class Peran extends BaseAdminController
{
    protected $peranModel;

    public function __construct()
    {
        $this->peranModel = new PeranModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Peran',
            'peran' => $this->peranModel->findAll()
        ];
        
        return view('admin/peran/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Peran Baru',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/peran/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_peran' => 'required|is_unique[sys_peran.nama_peran]',
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->peranModel->save([
            'nama_peran' => $this->request->getPost('nama_peran'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/' . tenant()->pkm_slug . '/peran')->with('msg', 'Data peran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peran = $this->peranModel->find($id);
        if (!$peran) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $data = [
            'title' => 'Edit Peran',
            'peran' => $peran,
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/peran/form', $data);
    }

    public function update($id)
    {
        $peran = $this->peranModel->find($id);
        if (!$peran) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $ruleNama = $peran['nama_peran'] == $this->request->getPost('nama_peran') ? 'required' : 'required|is_unique[sys_peran.nama_peran]';
        $rules = [
            'nama_peran' => $ruleNama,
            'deskripsi' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->peranModel->update($id, [
            'nama_peran' => $this->request->getPost('nama_peran'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ]);

        return redirect()->to('/admin/' . tenant()->pkm_slug . '/peran')->with('msg', 'Data peran berhasil diupdate.');
    }

    public function delete($id)
    {
        // Don't allow deletion of default roles or roles currently in use.
        // For simplicity, we just delete.
        $this->peranModel->delete($id);
        return redirect()->to('/admin/' . tenant()->pkm_slug . '/peran')->with('msg', 'Data peran berhasil dihapus.');
    }
}
