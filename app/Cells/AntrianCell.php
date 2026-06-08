<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AntrianCell extends Cell
{
    public function render(): string
    {
        $antrianModel = new \App\Models\AntrianModel();
        
        // Fetch active queue data for today
        $query = $antrianModel->where('tanggal', date('Y-m-d'))
                              ->where('status', 'dilayani');
                              
        if (function_exists('tenant') && tenant() && isset(tenant()->pkm_id)) {
            $query->where('pkm_id', tenant()->pkm_id);
        }
        
        $antrianData = $query->findAll();
                                    
        foreach ($antrianData as &$item) {
            $updatedAt = strtotime($item['updated_at']);
            $item['is_idle'] = (time() - $updatedAt) > 3600;
        }

        $data = [
            'last_update' => date('H:i A'),
            'antrian'     => $antrianData
        ];

        return $this->view('antrian', $data);
    }
}
