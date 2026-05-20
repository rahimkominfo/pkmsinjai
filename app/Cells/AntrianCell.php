<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AntrianCell extends Cell
{
    public function render(): string
    {
        // In a real application, you would fetch this data from a Model
        $data = [
            'last_update' => date('H:i A'),
            'antrian' => [
                [
                    'title'   => 'Pendaftaran',
                    'loket'   => 'Loket 01',
                    'nomor'   => 'A-042',
                    'petugas' => 'Budi Santoso',
                    'color'   => 'blue',
                    'icon'    => 'app_registration'
                ],
                [
                    'title'   => 'Poli Umum',
                    'loket'   => 'Ruang 01',
                    'nomor'   => 'B-015',
                    'petugas' => 'dr. Andi Wijaya',
                    'color'   => 'emerald',
                    'icon'    => 'stethoscope',
                    'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDPBgA4vQAgmXyI-uvjGCOS1fsZ7suFYwjgk57geGwdWbKm3q2WuN_lMJ2xMAXuPnKjPl3GRniS0rXgYVw1mLc61l9DuvSMwOxm70EPZwuT78dLMXYy25EW_fkJuEeaffUQi9zYB2y7hwtJELmgwLnUC_wnxzZrQDknAC4D4KB4KW7yDP1fls67uzSgz1SbFpBbaKi3xkU_aKuQU7YwUiYsSqd9ZjV_P5l3HJPcydIbCbf8Zm7-PzqYP041YEEjwP9LdikV6ByECF8Z'
                ],
                [
                    'title'   => 'Poli Gigi',
                    'loket'   => 'Ruang 04',
                    'nomor'   => 'C-009',
                    'petugas' => 'drg. Siti Aminah',
                    'color'   => 'indigo',
                    'icon'    => 'dentistry',
                    'img'     => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAswqt5rwhvnmcW9H51omYD_4iFU-BU4MRPGcd9TfqAe-GUXWg3gr0WjDe3eVo4-gnXKLyyrPJ6F0vpPYTg74qqwtvq-QYN5Nln59s-MwXSvXbM5Q6Loa27ymSaLFr2rKFo4rym0ZPA_UBmh-wiOhnxFvVIYrGh5MTAh-XGv6xKgCE0C-wY1rAnsw9rkWAOuSfoA7iIfXF_6rit7ktPPcSjaK1GtDu5uJcuuhude5im4fyEqdg9RrlQq2SIrWWPSnAq7tx69DOtIAt-'
                ],
                [
                    'title'   => 'Apotek / Farmasi',
                    'loket'   => 'Loket 1',
                    'nomor'   => 'D-038',
                    'petugas' => 'Tim Farmasi',
                    'color'   => 'orange',
                    'icon'    => 'medication'
                ],
            ]
        ];

        return $this->view('antrian', $data);
    }
}
