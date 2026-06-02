<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'mst_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['pkm_id', 'parent_id', 'title', 'url', 'sort_order', 'is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getMenusWithInduk($pkm_id)
    {
        return $this->select('mst_menu.*, induk.title as parent_title')
                    ->join('mst_menu as induk', 'induk.id = mst_menu.parent_id', 'left')
                    ->where('mst_menu.pkm_id', $pkm_id)
                    ->orderBy('mst_menu.sort_order', 'ASC')
                    ->orderBy('mst_menu.id', 'ASC')
                    ->findAll();
    }
    
    public function getActiveTree($pkm_id)
    {
        $menus = $this->where('pkm_id', $pkm_id)
                      ->where('is_active', 1)
                      ->orderBy('sort_order', 'ASC')
                      ->orderBy('id', 'ASC')
                      ->findAll();
                      
        $tree = [];
        $items = [];
        foreach($menus as $menu) {
            $menu['children'] = [];
            $items[$menu['id']] = $menu;
        }
        
        foreach($items as $id => &$item) {
            if ($item['parent_id'] && isset($items[$item['parent_id']])) {
                $items[$item['parent_id']]['children'][] = &$item;
            } else {
                $tree[] = &$item;
            }
        }
        
        return $tree;
    }
}
