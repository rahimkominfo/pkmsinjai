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
            $users = $this->userModel->select('sys_users.*, sys_peran.nama_peran as peran')
                                     ->join('sys_peran', 'sys_peran.peran_id = sys_users.peran_id', 'left')
                                     ->findAll();
        } else {
            $users = $this->userModel->select('sys_users.*, sys_peran.nama_peran as peran')
                                     ->join('sys_peran', 'sys_peran.peran_id = sys_users.peran_id', 'left')
                                     ->where('sys_users.pkm_id', $pkm_id)
                                     ->findAll();
        }

        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $users
        ];

        return view('admin/pengguna/index', $data);
    }

    public function create()
    {
        $peranModel = new \App\Models\PeranModel();
        $roles = $peranModel->findAll();
        
        if (session()->get('peran') === 'Admin PKM') {
            $roles = array_filter($roles, function($r) {
                return $r['nama_peran'] !== 'Admin Dinkes';
            });
        }
        
        $data = [
            'title' => 'Tambah Pengguna',
            'pkms'  => $this->pkmModel->findAll(),
            'roles' => $roles
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
            'konfirmasi_password' => 'required|matches[password]',
            'nama_publik' => 'required|min_length[3]',
            'peran_id'    => 'required|numeric'
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
            'peran_id'    => $this->request->getPost('peran_id')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->userModel->where('user_uuid', $uuid);

        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }

        $user = $query->first();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengguna tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $peranModel = new \App\Models\PeranModel();
        $roles = $peranModel->findAll();
        
        if (session()->get('peran') === 'Admin PKM') {
            $roles = array_filter($roles, function($r) {
                return $r['nama_peran'] !== 'Admin Dinkes';
            });
        }
        
        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $user,
            'pkms'  => $this->pkmModel->findAll(),
            'roles' => $roles
        ];

        return view('admin/pengguna/form', $data);
    }

    public function update($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->userModel->where('user_uuid', $uuid);

        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }

        $user = $query->first();
        
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengguna tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $user['user_id'];
        $rules = [
            'pkm_id'      => 'required',
            'username'    => "required|alpha_numeric_space|min_length[3]|is_unique[sys_users.username,user_id,{$id}]",
            'email'       => "required|valid_email|is_unique[sys_users.email,user_id,{$id}]",
            'nama_publik' => 'required|min_length[3]',
            'peran_id'    => 'required|numeric'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['konfirmasi_password'] = 'required|matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $target_pkm_id = $this->request->getPost('pkm_id');

        $updateData = [
            'pkm_id'      => $target_pkm_id === 'super' ? null : $target_pkm_id,
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'nama_publik' => $this->request->getPost('nama_publik'),
            'peran_id'    => $this->request->getPost('peran_id')
        ];

        if ($password = $this->request->getPost('password')) {
            $updateData['password'] = $password;
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil diupdate.');
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->userModel->where('user_uuid', $uuid);

        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }

        $user = $query->first();

        if ($user && $this->userModel->delete($user['user_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('message', 'Pengguna berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/pengguna')->with('error', 'Gagal menghapus pengguna atau Anda tidak memiliki akses.');
    }
}
