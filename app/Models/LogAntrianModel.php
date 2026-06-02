<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAntrianModel extends Model
{
    protected $table            = 'log_antrian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'pkm_id', 
        'antrian_id', 
        'peran_id',
        'title', 
        'nomor_terakhir', 
        'total_pengunjung',
        'tanggal'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
