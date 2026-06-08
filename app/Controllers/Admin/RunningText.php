<?php

namespace App\Controllers\Admin;

use App\Models\RunningTextModel;
use App\Models\PkmModel;

class RunningText extends BaseAdminController
{
    protected $runningTextModel;

    public function __construct()
    {
        $this->runningTextModel = new RunningTextModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');
        $filter_pkm_id = $pkm_id;

        $data = [
            'title' => 'Manajemen Teks Berjalan',
        ];

        if ($pkm_id === 'super') {
            $pkmModel = new PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
            
            $query = $this->runningTextModel->select('mst_running_text.*, mst_pkm.pkm_nama')
                                          ->join('mst_pkm', 'mst_pkm.pkm_id = mst_running_text.pkm_id', 'left');
            
            if ($filter_pkm_id !== 'super' && !empty($filter_pkm_id)) {
                $query->where('mst_running_text.pkm_id', $filter_pkm_id);
            }
            
            $data['running_texts'] = $query->findAll();
        } else {
            $data['running_texts'] = $this->runningTextModel->where('pkm_id', $pkm_id)->findAll();
        }

        return view('admin/running_text/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Teks Berjalan',
        ];

        if (tenant()->pkm_id === 'super') {
            $pkmModel = new PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/running_text/form', $data);
    }

    public function store()
    {
        $rules = [
            'teks' => 'required|min_length[5]'
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

        $this->runningTextModel->insert([
            'pkm_id'    => $pkm_id,
            'teks'      => $this->request->getPost('teks'),
            'is_active' => $this->request->getPost('is_active') ?? 1
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/running-text')->with('message', 'Teks berjalan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $runningText = $this->runningTextModel->find($id);

        if (!$runningText) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Teks berjalan tidak ditemukan');
        }

        $data = [
            'title'        => 'Edit Teks Berjalan',
            'running_text' => $runningText
        ];

        if (tenant()->pkm_id === 'super') {
            $pkmModel = new PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/running_text/form', $data);
    }

    public function update($id)
    {
        $runningText = $this->runningTextModel->find($id);

        if (!$runningText) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Teks berjalan tidak ditemukan');
        }

        $rules = [
            'teks' => 'required|min_length[5]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->runningTextModel->update($id, [
            'teks'      => $this->request->getPost('teks'),
            'is_active' => $this->request->getPost('is_active') ?? 1
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/running-text')->with('message', 'Teks berjalan berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($this->runningTextModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/running-text')->with('message', 'Teks berjalan berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/running-text')->with('error', 'Gagal menghapus teks berjalan.');
    }

    public function toggle($id)
    {
        $runningText = $this->runningTextModel->find($id);
        if ($runningText) {
            $this->runningTextModel->update($id, ['is_active' => $runningText['is_active'] == 1 ? 0 : 1]);
        }
        return redirect()->to('admin/' . tenant()->pkm_slug . '/running-text');
    }
}
