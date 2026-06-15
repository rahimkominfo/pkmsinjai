<?php

namespace App\Controllers\Admin;

use App\Models\MstFlyerModel;

class Flyer extends BaseAdminController
{
    protected $flyerModel;

    public function __construct()
    {
        $this->flyerModel = new MstFlyerModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');

        $data = [
            'title' => 'Manajemen Flyer',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['flyers'] = $this->flyerModel->getFlyersWithPkm($filter_pkm_id);

        return view('admin/flyer/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title' => 'Tambah Flyer',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/flyer/form', $data);
    }

    public function store()
    {
        $rules = [
            'judul'      => 'required|min_length[3]',
            'gambar_url' => 'required',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]'
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

        $this->flyerModel->insert([
            'pkm_id'     => $pkm_id,
            'judul'      => $this->request->getPost('judul'),
            'gambar_url' => $this->request->getPost('gambar_url'),
            'label'      => $this->request->getPost('label'),
            'status'     => $this->request->getPost('status'),
            'urutan'     => $this->request->getPost('urutan') ?? 0
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/flyer')->with('message', 'Flyer berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->flyerModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $flyer = $query->first();

        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Flyer tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $data = [
            'title' => 'Edit Flyer',
            'flyer' => $flyer
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/flyer/form', $data);
    }

    public function update($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->flyerModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $flyer = $query->first();
        
        if (!$flyer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Flyer tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $id = $flyer['flayer_id'];
        $rules = [
            'judul'      => 'required|min_length[3]',
            'gambar_url' => 'required',
            'status'     => 'required|in_list[Aktif,Tidak Aktif]'
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
            'judul'      => $this->request->getPost('judul'),
            'gambar_url' => $this->request->getPost('gambar_url'),
            'label'      => $this->request->getPost('label'),
            'status'     => $this->request->getPost('status'),
            'urutan'     => $this->request->getPost('urutan') ?? 0
        ];
        
        if ($pkm_id === 'super') {
            $updateData['pkm_id'] = $target_pkm_id;
        }

        $this->flyerModel->update($id, $updateData);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/flyer')->with('message', 'Flyer berhasil diupdate.');
    }

    public function delete($uuid)
    {
        $pkm_id = tenant()->pkm_id;
        $query = $this->flyerModel->where('uuid', $uuid);
        
        if ($pkm_id !== 'super') {
            $query->where('pkm_id', $pkm_id);
        }
        
        $flyer = $query->first();

        if ($flyer && $this->flyerModel->delete($flyer['flayer_id'])) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/flyer')->with('message', 'Flyer berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/flyer')->with('error', 'Gagal menghapus flyer atau data tidak ditemukan/tidak memiliki akses.');
    }
}
