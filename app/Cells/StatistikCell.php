<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\StatistikPenyakitModel;

class StatistikCell extends Cell
{
    public function render(): string
    {
        $model = new StatistikPenyakitModel();
        
        // Get tenant information from helper (as set by filter)
        $pkm = tenant();
        $pkm_id = $pkm->pkm_id ?? null;
        
        // Get selected period from GET request
        $selected_periode = service('request')->getGet('periode');
        
        $query = $model->where('pkm_id', $pkm_id);
        
        if ($selected_periode) {
            $parts = explode('|', $selected_periode);
            if (count($parts) === 2) {
                $query->where('periode_awal', $parts[0])
                      ->where('periode_akhir', $parts[1]);
            }
        }

        // Fetch top 10 diseases for the current PKM, ordered by total
        $penyakit_data = $query->orderBy('total', 'DESC')
                             ->limit(10)
                             ->findAll();

        // Get available periods for filter
        $list_periode = $model->select('periode_awal, periode_akhir')
                             ->where('pkm_id', $pkm_id)
                             ->groupBy('periode_awal, periode_akhir')
                             ->orderBy('periode_awal', 'DESC')
                             ->findAll();

        $penyakit = [];
        $max_jumlah = 0;
        
        foreach ($penyakit_data as $item) {
            if ($item['total'] > $max_jumlah) {
                $max_jumlah = $item['total'];
            }
        }

        foreach ($penyakit_data as $item) {
            $penyakit[] = [
                'kode' => $item['kode_diagnosa'],
                'nama' => $item['diagnosa'],
                'jumlah' => $item['total'],
                'percent' => ($max_jumlah > 0) ? (($item['total'] / $max_jumlah) * 100) . '%' : '0%'
            ];
        }

        // Fallback data if no data found
        if (empty($penyakit)) {
            $penyakit = [
                ['kode' => '-', 'nama' => 'No Data', 'jumlah' => 0, 'percent' => '0%'],
            ];
        }

        $data = [
            'penyakit' => $penyakit,
            'max_jumlah' => $max_jumlah,
            'list_periode' => $list_periode,
            'selected_periode' => $selected_periode
        ];

        return $this->view('statistik', $data);
    }
}
