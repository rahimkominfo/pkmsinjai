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

    protected $beforeInsert = ['generateUUID'];

    protected function generateUUID(array $data)
    {
        if (!isset($data['data']['artikel_uuid'])) {
            $data['data']['artikel_uuid'] = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    public function getPublished($pkm_id, $limit = 0, $search = null)
    {
        $builder = $this->select('trn_artikel.*, (SELECT mst_kategori.nama FROM trn_artikel_kategori JOIN mst_kategori ON mst_kategori.kategori_id = trn_artikel_kategori.kategori_id WHERE trn_artikel_kategori.artikel_id = trn_artikel.artikel_id LIMIT 1) as nama_kategori')
                        ->where('trn_artikel.pkm_id', $pkm_id)
                        ->where('trn_artikel.status', 'Ditayangkan');
                        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('trn_artikel.judul', $search)
                    ->orLike('trn_artikel.abstrak', $search)
                    ->orLike('trn_artikel.konten', $search)
                    ->groupEnd();
        }
        
        $builder->orderBy('trn_artikel.tanggal_publikasi', 'DESC');
        
        if ($limit > 0) {
            return $builder->findAll($limit);
        }
        return $builder->findAll();
    }

    public function getBySlug($slug, $pkm_id)
    {
        return $this->select('trn_artikel.*, (SELECT mst_kategori.nama FROM trn_artikel_kategori JOIN mst_kategori ON mst_kategori.kategori_id = trn_artikel_kategori.kategori_id WHERE trn_artikel_kategori.artikel_id = trn_artikel.artikel_id LIMIT 1) as nama_kategori')
                    ->where('trn_artikel.slug', $slug)
                    ->where('trn_artikel.pkm_id', $pkm_id)
                    ->where('trn_artikel.status', 'Ditayangkan')
                    ->first();
    }

    public function getPopular($pkm_id, $limit = 5)
    {
        $builder = $this->select('trn_artikel.*, (SELECT mst_kategori.nama FROM trn_artikel_kategori JOIN mst_kategori ON mst_kategori.kategori_id = trn_artikel_kategori.kategori_id WHERE trn_artikel_kategori.artikel_id = trn_artikel.artikel_id LIMIT 1) as nama_kategori')
                        ->where('trn_artikel.pkm_id', $pkm_id)
                        ->where('trn_artikel.status', 'Ditayangkan')
                        ->orderBy('trn_artikel.jumlah_tayang', 'DESC')
                        ->orderBy('trn_artikel.tanggal_publikasi', 'DESC');
        
        if ($limit > 0) {
            return $builder->findAll($limit);
        }
        return $builder->findAll();
    }

    public function getArtikelWithAuthor($pkm_id)
    {
        $builder = $this->select('trn_artikel.*, sys_users.nama_publik as penulis, mst_pkm.pkm_nama')
                        ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id', 'left')
                        ->join('mst_pkm', 'mst_pkm.pkm_id = trn_artikel.pkm_id', 'left');
                        
        if ($pkm_id !== 'super' && $pkm_id !== '') {
            $builder->where('trn_artikel.pkm_id', $pkm_id);
        }
        
        return $builder->orderBy('trn_artikel.tanggal_publikasi', 'DESC')
                       ->findAll();
    }

    public function getCategories($artikel_id)
    {
        $db = \Config\Database::connect();
        return $db->table('trn_artikel_kategori')
                  ->where('artikel_id', $artikel_id)
                  ->get()
                  ->getResultArray();
    }

    public function syncCategories($artikel_id, $pkm_id, $kategori_ids)
    {
        $db = \Config\Database::connect();
        
        // Hapus mapping lama
        $db->table('trn_artikel_kategori')
           ->where('artikel_id', $artikel_id)
           ->delete();
           
        // Masukkan mapping baru
        if (!empty($kategori_ids) && is_array($kategori_ids)) {
            $data = [];
            foreach ($kategori_ids as $kat_id) {
                $data[] = [
                    'artikel_id'  => $artikel_id,
                    'pkm_id'      => $pkm_id,
                    'kategori_id' => $kat_id
                ];
            }
            $db->table('trn_artikel_kategori')->insertBatch($data);
        }
    }
}
