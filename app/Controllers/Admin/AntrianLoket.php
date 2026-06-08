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
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');
        
        $data = [
            'title'   => 'Update Antrian Loket - ' . tenant()->pkm_nama,
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
            $data['title'] = 'Update Antrian Loket';
        }
        
        $builder = $this->antrianModel->select('trn_antrian.*, mst_pkm.pkm_nama')
                                      ->join('mst_pkm', 'mst_pkm.pkm_id = trn_antrian.pkm_id', 'left');
        
        if ($filter_pkm_id !== 'super' && $filter_pkm_id !== '') {
            $builder = $builder->where('trn_antrian.pkm_id', $filter_pkm_id);
        }
        
        // Jika bukan admin, hanya bisa melihat antrian sesuai perannya
        if (!in_array($role, ['Admin Dinkes', 'Admin PKM'])) {
            $builder = $builder->where('trn_antrian.peran_id', $peran_id);
        }
        
        $antrian = $builder->orderBy('trn_antrian.id', 'ASC')->findAll();
        
        if ($pkm_id === 'super' && $filter_pkm_id !== 'super' && $filter_pkm_id !== '') {
            $pkmModel = new \App\Models\PkmModel();
            $selectedPkmData = $pkmModel->find($filter_pkm_id);
            if ($selectedPkmData) {
                $data['title'] = 'Update Antrian Loket - ' . $selectedPkmData['pkm_nama'];
            }
        }

        $data['antrian'] = $antrian;
        
        return view('admin/antrian/loket', $data);
    }

    public function update($id)
    {
        $nomorBaru = $this->request->getPost('nomor');
        $role = session()->get('peran');
        $peran_id = session()->get('peran_id');
        $pkm_id = tenant()->pkm_id;
        
        $builder = $this->antrianModel;
        
        if ($pkm_id !== 'super') {
            $builder = $builder->where('pkm_id', $pkm_id);
        }
        
        if (!in_array($role, ['Admin Dinkes', 'Admin PKM'])) {
            $builder = $builder->where('peran_id', $peran_id);
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
