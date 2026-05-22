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

    public function getArtikelWithAuthor($pkm_id)
    {
        return $this->select('trn_artikel.*, sys_users.nama_publik as penulis')
                    ->join('sys_users', 'sys_users.user_id = trn_artikel.user_id', 'left')
                    ->where('trn_artikel.pkm_id', $pkm_id)
                    ->orderBy('trn_artikel.tanggal_publikasi', 'DESC')
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
