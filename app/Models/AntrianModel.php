<?php

namespace App\Models;

use CodeIgniter\Model;

class AntrianModel extends Model
{
    protected $table            = 'trn_antrian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'pkm_id', 
        'peran_id',
        'title', 
        'loket', 
        'nomor', 
        'petugas', 
        'color', 
        'icon', 
        'img', 
        'status', 
        'tanggal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getAntrianHariIni($pkm_id)
    {
        return $this->where('pkm_id', $pkm_id)
                    ->where('tanggal', date('Y-m-d'))
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
