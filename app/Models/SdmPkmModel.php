<?php

namespace App\Models;

use CodeIgniter\Model;

class SdmPkmModel extends Model
{
    protected $table            = 'mst_sdm_pkm';
    protected $primaryKey       = 'sdm_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'pkm_id',
        'uuid',
        'foto_pegawai',
        'nama_lengkap',
        'profesi_jabatan',
        'unit_poli'
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

    public function getSdmWithPkm($pkm_id)
    {
        $builder = $this->select('mst_sdm_pkm.*, mst_pkm.pkm_nama, mst_pkm.pkm_slug')
                        ->join('mst_pkm', 'mst_pkm.pkm_id = mst_sdm_pkm.pkm_id', 'left');
                        
        if ($pkm_id !== 'super' && $pkm_id !== '') {
            $builder->where('mst_sdm_pkm.pkm_id', $pkm_id);
        }
        
        $builder->orderBy('mst_sdm_pkm.nama_lengkap', 'ASC');
        
        return $builder->findAll();
    }
}

