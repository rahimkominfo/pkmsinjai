<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{
    protected $table            = 'mst_pages';
    protected $primaryKey       = 'page_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'pkm_id',
        'page_uuid',
        'judul',
        'slug',
        'konten',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        if (!isset($data['data']['page_uuid'])) {
            $data['data']['page_uuid'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    public function getPagesWithPkm($pkm_id)
    {
        $builder = $this->select('mst_pages.*, mst_pkm.pkm_nama, mst_pkm.pkm_slug')
                        ->join('mst_pkm', 'mst_pkm.pkm_id = mst_pages.pkm_id', 'left');
                        
        if ($pkm_id !== 'super' && $pkm_id !== '') {
            $builder->where('mst_pages.pkm_id', $pkm_id);
        }
        
        return $builder->findAll();
    }
}
