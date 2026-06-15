<?php

namespace App\Controllers\Admin;

use App\Models\SdmPkmModel;

class SdmPkmController extends BaseAdminController
{
    protected $sdmModel;

    public function __construct()
    {
        $this->sdmModel = new SdmPkmModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');

        $data = [
            'title' => 'Manajemen SDM PKM',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['sdm'] = $this->sdmModel->getSdmWithPkm($filter_pkm_id);

        return view('admin/sdm_pkm/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title' => 'Tambah SDM PKM',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/sdm_pkm/form', $data);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap'    => 'required|min_length[3]',
            'profesi_jabatan' => 'required',
            'unit_poli'       => 'required'
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }

        $this->sdmModel->insert([
            'pkm_id'          => $pkm_id,
            'nama_lengkap'    => $this->request->getPost('nama_lengkap'),
            'profesi_jabatan' => $this->request->getPost('profesi_jabatan'),
            'unit_poli'       => $this->request->getPost('unit_poli'),
            'foto_pegawai'    => $this->request->getPost('foto_pegawai')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/sdm-pkm')->with('message', 'SDM PKM berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->sdmModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $sdm = $query->first();

        if (!$sdm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data SDM tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $data = [
            'title' => 'Edit SDM PKM',
            'sdm'   => $sdm
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/sdm_pkm/form', $data);
    }

    public function update($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->sdmModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $sdm = $query->first();
        
        if (!$sdm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data SDM tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $sdm['sdm_id'];
        $rules = [
            'nama_lengkap'    => 'required|min_length[3]',
            'profesi_jabatan' => 'required',
            'unit_poli'       => 'required'
        ];
        
        if ($pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $target_pkm_id = $pkm_id;
        if ($pkm_id === 'super') {
            $target_pkm_id = $this->request->getPost('pkm_id');
        }

        $updateData = [
            'nama_lengkap'    => $this->request->getPost('nama_lengkap'),
            'profesi_jabatan' => $this->request->getPost('profesi_jabatan'),
            'unit_poli'       => $this->request->getPost('unit_poli'),
            'foto_pegawai'    => $this->request->getPost('foto_pegawai')
        ];
        
        if ($pkm_id === 'super') {
            $updateData['pkm_id'] = $target_pkm_id;
        }

        $this->sdmModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/sdm-pkm')->with('message', 'SDM PKM berhasil diupdate.');
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->sdmModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $sdm = $query->first();

        if ($sdm && $this->sdmModel->delete($sdm['sdm_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/sdm-pkm')->with('message', 'SDM PKM berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/sdm-pkm')->with('error', 'Gagal menghapus data atau data tidak ditemukan/tidak memiliki akses.');
    }
}
