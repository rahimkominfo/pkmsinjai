<?php

namespace App\Models;

use CodeIgniter\Model;

class RunningTextModel extends Model
{
    protected $table            = 'mst_running_text';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['pkm_id', 'teks', 'is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Get active running texts for a specific PKM.
     */
    public function getActive($pkmId)
    {
        return $this->where('pkm_id', $pkmId)
                    ->where('is_active', 1)
                    ->findAll();
    }
}
