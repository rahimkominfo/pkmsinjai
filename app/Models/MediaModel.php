<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table            = 'mst_media';
    protected $primaryKey       = 'media_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pkm_id', 'nama_file', 'url_file', 'tipe_file', 'caption', 'user_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getMediaList($pkm_id)
    {
        $builder = $this->select('mst_media.*, mst_pkm.pkm_nama')
                        ->join('mst_pkm', 'mst_pkm.pkm_id = mst_media.pkm_id', 'left');
                        
        if ($pkm_id !== 'super' && $pkm_id !== '') {
            $builder->where('mst_media.pkm_id', $pkm_id);
        }
        
        return $builder->orderBy('mst_media.created_at', 'DESC')
                       ->findAll();
    }
}
