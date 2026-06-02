<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PkmModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            $pkm_slug = session()->get('pkm_slug') ?? 'super';
            return redirect()->to('/admin/' . $pkm_slug . '/dashboard');
        }

        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $userModel = new UserModel();
        $pkmModel = new PkmModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $data = $userModel->select('sys_users.*, sys_peran.nama_peran as peran')
                          ->join('sys_peran', 'sys_peran.peran_id = sys_users.peran_id', 'left')
                          ->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                // Get PKM Slug
                $pkm_slug = 'super';
                if ($data['pkm_id']) {
                    $pkm = $pkmModel->find($data['pkm_id']);
                    if ($pkm) {
                        $pkm_slug = $pkm['pkm_slug'];
                    }
                }
                
                $ses_data = [
                    'user_id'       => $data['user_id'],
                    'user_uuid'     => $data['user_uuid'],
                    'username'      => $data['username'],
                    'nama_publik'   => $data['nama_publik'],
                    'peran'         => $data['peran'],
                    'peran_id'      => $data['peran_id'],
                    'pkm_id'        => $data['pkm_id'],
                    'pkm_slug'      => $pkm_slug,
                    'isLoggedIn'    => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/admin/' . $pkm_slug . '/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password salah.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
