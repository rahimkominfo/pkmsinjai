<?php

namespace App\Controllers\Admin;

use App\Models\AntrianModel;

class AntrianLoket extends BaseAdminController
{
    protected $antrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $role = session()->get('peran');
        $peran_id = session()->get('peran_id');
        
        $builder = $this->antrianModel->where('pkm_id', $pkm_id);
        
        // Jika bukan admin, hanya bisa melihat antrian sesuai perannya
        if (!in_array($role, ['Admin Dinkes', 'Admin PKM'])) {
            $builder->where('peran_id', $peran_id);
        }
        
        $antrian = $builder->findAll();

        $data = [
            'title'   => 'Update Antrian Loket - ' . tenant()->pkm_nama,
            'antrian' => $antrian
        ];
        
        return view('admin/antrian/loket', $data);
    }

    public function update($id)
    {
        $nomorBaru = $this->request->getPost('nomor');
        $role = session()->get('peran');
        $peran_id = session()->get('peran_id');
        
        $builder = $this->antrianModel->where('pkm_id', tenant()->pkm_id);
        if (!in_array($role, ['Admin Dinkes', 'Admin PKM'])) {
            $builder->where('peran_id', $peran_id);
        }
        
        // Memastikan antrian milik tenant yang sedang aktif dan sesuai peran
        $antrian = $builder->find($id);
        
        if (!$antrian) {
            return redirect()->back()->with('error', 'Antrian tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $this->antrianModel->update($id, ['nomor' => $nomorBaru]);
        
        return redirect()->back()->with('message', "Nomor antrian untuk bagian {$antrian['title']} berhasil diperbarui menjadi {$nomorBaru}.");
    }
}
