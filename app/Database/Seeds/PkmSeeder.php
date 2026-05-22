<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\PkmModel;

class PkmSeeder extends Seeder
{
    public function run()
    {
        $model = new PkmModel();

        $data = [
            [
                'pkm_nama'      => 'PKM Balangnipa',
                'pkm_slug'      => 'balangnipa',
                'primary_color' => '#006c4a',
                'logo'          => null,
                'header_img'    => null,
            ],
            [
                'pkm_nama'      => 'PKM Panaikang',
                'pkm_slug'      => 'panaikang',
                'primary_color' => '#0284c7', // Sky blue example
                'logo'          => null,
                'header_img'    => null,
            ],
            [
                'pkm_nama'      => 'PKM Samataring',
                'pkm_slug'      => 'samataring',
                'primary_color' => '#ea580c', // Orange example
                'logo'          => null,
                'header_img'    => null,
            ]
        ];

        foreach ($data as $pkm) {
            // Cek agar tidak duplikat
            if (!$model->where('pkm_slug', $pkm['pkm_slug'])->first()) {
                $model->insert($pkm);
            }
        }
    }
}
