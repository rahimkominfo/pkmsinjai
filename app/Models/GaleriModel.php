<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $table            = 'trn_galeri';
    protected $primaryKey       = 'galeri_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['pkm_id', 'judul', 'sampul_url', 'deskripsi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getGaleriWithCount($pkm_id)
    {
        return $this->select('trn_galeri.*, COUNT(trn_galeri_gambar.galeri_gambar_id) as jumlah_foto')
                    ->join('trn_galeri_gambar', 'trn_galeri_gambar.galeri_id = trn_galeri.galeri_id', 'left')
                    ->where('trn_galeri.pkm_id', $pkm_id)
                    ->groupBy('trn_galeri.galeri_id')
                    ->orderBy('trn_galeri.created_at', 'DESC')
                    ->findAll();
    }
}
