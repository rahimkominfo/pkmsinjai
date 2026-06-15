<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Menu extends BaseAdminController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        
        $filter_pkm_id = $pkm_id;
        $selected_pkm = $this->request->getGet('pkm_id');

        $data = [
            'title' => 'Manajemen Menu',
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
            
            if ($selected_pkm !== null && $selected_pkm !== '') {
                $filter_pkm_id = $selected_pkm;
            }
            $data['selected_pkm'] = $filter_pkm_id;
        }

        $data['menus'] = $this->menuModel->getMenusWithInduk($filter_pkm_id);

        return view('admin/menu/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;
        
        $data = [
            'title'        => 'Tambah Menu',
            'parent_menus' => $this->menuModel->getAllTree($pkm_id)
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }
        
        return view('admin/menu/form', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'url'   => 'required'
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parent_id = $this->request->getPost('parent_id');
        $is_active = $this->request->getPost('is_active') ? 1 : 0;
        
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }

        $this->menuModel->insert([
            'pkm_id'     => $pkm_id,
            'title'      => $this->request->getPost('title'),
            'url'        => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active'  => $is_active,
            'parent_id'  => empty($parent_id) ? null : $parent_id
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('message', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $menu = $this->menuModel->find($id);
        } else {
            $menu = $this->menuModel->where('pkm_id', $pkm_id)->find($id);
        }

        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Menu tidak ditemukan');
        }
        
        $data = [
            'title'        => 'Edit Menu',
            'menu'         => $menu,
            'parent_menus' => $this->menuModel->getAllTree($pkm_id, $id)
        ];
        
        if ($pkm_id === 'super') {
            $pkmModel = new \App\Models\PkmModel();
            $data['list_pkm'] = $pkmModel->findAll();
        }

        return view('admin/menu/form', $data);
    }

    public function update($id)
    {
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $menu = $this->menuModel->find($id);
        } else {
            $menu = $this->menuModel->where('pkm_id', $pkm_id)->find($id);
        }
        
        if (!$menu) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Menu tidak ditemukan');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'url'   => 'required'
        ];
        
        if (tenant()->pkm_id === 'super') {
            $rules['pkm_id'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parent_id = $this->request->getPost('parent_id');
        $is_active = $this->request->getPost('is_active') ? 1 : 0;
        
        if ($pkm_id === 'super') {
            $pkm_id = $this->request->getPost('pkm_id');
        }

        $this->menuModel->update($id, [
            'pkm_id'     => $pkm_id,
            'title'      => $this->request->getPost('title'),
            'url'        => $this->request->getPost('url'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active'  => $is_active,
            'parent_id'  => empty($parent_id) ? null : $parent_id
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('message', 'Menu berhasil diupdate.');
    }

    public function delete($id)
    {
        $pkm_id = tenant()->pkm_id;
        if ($pkm_id === 'super') {
            $menu = $this->menuModel->find($id);
        } else {
            $menu = $this->menuModel->where('pkm_id', $pkm_id)->find($id);
        }
        
        if (!$menu) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('error', 'Menu tidak ditemukan.');
        }
        
        // Cek jika menu punya sub menu
        $hasChildren = $this->menuModel->where('parent_id', $id)->countAllResults();
        if ($hasChildren > 0) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('error', 'Gagal menghapus menu karena memiliki submenu.');
        }

        if ($this->menuModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('message', 'Menu berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/menu')->with('error', 'Gagal menghapus menu.');
    }
}
