<?php

namespace App\Models;

use CodeIgniter\Model;

class MstFlyerModel extends Model
{
    protected $table            = 'mst_flyer';
    protected $primaryKey       = 'flayer_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'pkm_id',
        'uuid',
        'judul',
        'gambar_url',
        'label',
        'status',
        'urutan'
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
        if (!isset($data['data']['uuid'])) {
            $data['data']['uuid'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    public function getFlyersWithPkm($pkm_id)
    {
        $builder = $this->select('mst_flyer.*, mst_pkm.pkm_nama, mst_pkm.pkm_slug')
                        ->join('mst_pkm', 'mst_pkm.pkm_id = mst_flyer.pkm_id', 'left');
                        
        if ($pkm_id !== 'super' && $pkm_id !== '') {
            $builder->where('mst_flyer.pkm_id', $pkm_id);
        }
        
        $builder->orderBy('mst_flyer.urutan', 'ASC');
        
        return $builder->findAll();
    }
}
