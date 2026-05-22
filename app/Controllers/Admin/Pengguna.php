<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PkmModel;

class Pengguna extends BaseAdminController
{
    protected $userModel;
    protected $pkmModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->pkmModel = new PkmModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id; 

        if ($pkm_id === 'super') {
            $users = $this->userModel->findAll();
        } else {
            $users = $this->userModel->where('pkm_id', $pkm_id)->findAll();
        }

        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $users
        ];

        return view('admin/pengguna/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'pkms'  => $this->pkmModel->findAll()
        ];
        return view('admin/pengguna/form', $data);
    }

    public function store()
    {
        $rules = [
            'pkm_id'      => 'required',
            'username'    => 'required|alpha_numeric_space|min_length[3]|is_unique[sys_users.username]',
            'email'       => 'required|valid_email|is_unique[sys_users.email]',
            'password'    => 'required|min_length[6]',
            'nama_publik' => 'required|min_length[3]',
            'peran'       => 'required|in_list[Admin,Editor,Kontributor]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = $this->request->getPost('pkm_id');

        $this->userModel->insert([
            'pkm_id'      => $pkm_id === 'super' ? null : $pkm_id,
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => $this->request->getPost('password'),
            'nama_publik' => $this->request->getPost('nama_publik'),
            'peran'       => $this->request->getPost('peran')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $user,
            'pkms'  => $this->pkmModel->findAll()
        ];

        return view('admin/pengguna/form', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengguna tidak ditemukan');
        }

        $rules = [
            'pkm_id'      => 'required',
            'username'    => "required|alpha_numeric_space|min_length[3]|is_unique[sys_users.username,user_id,{$id}]",
            'email'       => "required|valid_email|is_unique[sys_users.email,user_id,{$id}]",
            'nama_publik' => 'required|min_length[3]',
            'peran'       => 'required|in_list[Admin,Editor,Kontributor]'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = $this->request->getPost('pkm_id');

        $updateData = [
            'pkm_id'      => $pkm_id === 'super' ? null : $pkm_id,
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'nama_publik' => $this->request->getPost('nama_publik'),
            'peran'       => $this->request->getPost('peran')
        ];

        if ($password = $this->request->getPost('password')) {
            $updateData['password'] = $password;
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('error', 'Gagal menghapus pengguna.');
    }
}
