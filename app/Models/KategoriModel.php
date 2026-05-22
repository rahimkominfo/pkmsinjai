<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'mst_kategori';
    protected $primaryKey       = 'kategori_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    
    protected $allowedFields    = [
        'pkm_id',
        'nama',
        'slug',
        'kategori_induk_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Helper untuk mengambil kategori beserta nama induknya (jika ada)
    public function getKategoriWithInduk($pkm_id)
    {
        return $this->select('mst_kategori.*, induk.nama as nama_induk')
                    ->join('mst_kategori as induk', 'induk.kategori_id = mst_kategori.kategori_induk_id', 'left')
                    ->where('mst_kategori.pkm_id', $pkm_id)
                    ->findAll();
    }
}
