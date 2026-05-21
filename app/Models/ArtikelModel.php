<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'trn_artikel';
    protected $primaryKey       = 'artikel_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pkm_id', 'artikel_uuid', 'judul', 'slug', 'konten', 
        'gambar_utama', 'abstrak', 'user_id', 'status', 
        'jumlah_tayang', 'tanggal_publikasi'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tanggal_publikasi';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getPublished($pkm_id, $limit = 0)
    {
        $builder = $this->where('pkm_id', $pkm_id)
                        ->where('status', 'Ditayangkan')
                        ->orderBy('tanggal_publikasi', 'DESC');
        
        if ($limit > 0) {
            return $builder->findAll($limit);
        }
        return $builder->findAll();
    }

    public function getBySlug($slug, $pkm_id)
    {
        return $this->where('slug', $slug)
                    ->where('pkm_id', $pkm_id)
                    ->where('status', 'Ditayangkan')
                    ->first();
    }
}
