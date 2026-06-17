<?php

namespace App\Controllers\Frontend;

use App\Models\AntrianModel;
use App\Models\RunningTextModel;

class DisplayAntrian extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;

        // Fetch running text
        $runningTextModel = new RunningTextModel();
        $runningTextData = $runningTextModel->where('pkm_id', $pkm_id)
                                            ->where('is_active', 1)
                                            ->findAll();
        
        $marqueeText = "Selamat Datang di " . tenant()->pkm_nama . ". Mohon menunggu hingga nomor antrian Anda dipanggil.";
        if (!empty($runningTextData)) {
            $texts = array_column($runningTextData, 'teks');
            $marqueeText = implode('  ***  ', $texts);
        }

        $data = [
            'title' => 'Display Antrian - ' . tenant()->pkm_nama,
            'marquee_text' => $marqueeText
        ];

        return view('frontend/display_antrian/index', $data);
    }

    public function data()
    {
        // Set header to JSON explicitly
        $this->response->setContentType('application/json');

        $pkm_id = tenant()->pkm_id;
        $antrianModel = new AntrianModel();
        
        $antrianData = $antrianModel->where('tanggal', date('Y-m-d'))
                                    ->where('status', 'dilayani')
                                    ->where('pkm_id', $pkm_id)
                                    ->findAll();
                                    
        $formattedData = [];
        foreach ($antrianData as $item) {
            $formattedData[] = [
                'id' => $item['id'],
                'loket' => $item['loket'],
                'title' => $item['title'],
                'nomor' => $item['nomor'],
                'petugas' => $item['petugas'],
                'color' => $item['color'] ?? '#0ea5e9',
                'updated_at' => $item['updated_at']
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $formattedData,
            'timestamp' => time()
        ]);
    }
}
