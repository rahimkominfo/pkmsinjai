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

        $data = [
            'title' => 'Manajemen Menu',
            'menus' => $this->menuModel->getMenusWithInduk($pkm_id)
        ];

        return view('admin/menu/index', $data);
    }

    public function create()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'        => 'Tambah Menu',
            'parent_menus' => $this->menuModel->where('pkm_id', $pkm_id)->where('parent_id', null)->findAll()
        ];
        
        return view('admin/menu/form', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'url'   => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parent_id = $this->request->getPost('parent_id');
        $is_active = $this->request->getPost('is_active') ? 1 : 0;

        $this->menuModel->insert([
            'pkm_id'     => tenant()->pkm_id,
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
        $menu = $this->menuModel->find($id);

        if (!$menu || $menu['pkm_id'] != $pkm_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Menu tidak ditemukan');
        }

        $data = [
            'title'        => 'Edit Menu',
            'menu'         => $menu,
            'parent_menus' => $this->menuModel->where('pkm_id', $pkm_id)
                                              ->where('id !=', $id)
                                              ->where('parent_id', null)
                                              ->findAll()
        ];

        return view('admin/menu/form', $data);
    }

    public function update($id)
    {
        $pkm_id = tenant()->pkm_id;
        $menu = $this->menuModel->find($id);
        
        if (!$menu || $menu['pkm_id'] != $pkm_id) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Menu tidak ditemukan');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'url'   => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $parent_id = $this->request->getPost('parent_id');
        $is_active = $this->request->getPost('is_active') ? 1 : 0;

        $this->menuModel->update($id, [
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
        $menu = $this->menuModel->find($id);
        
        if (!$menu || $menu['pkm_id'] != $pkm_id) {
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
