<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class StatistikCell extends Cell
{
    public function render(): string
    {
        // In a real application, you would fetch this data from a Model
        $data = [
            'penyakit' => [
                ['kode' => 'K05', 'nama' => 'Gingivitis dan penyakit periodontal', 'jumlah' => 11, 'percent' => '91.6%'],
                ['kode' => 'I10', 'nama' => 'Hipertensi esensial (primer)', 'jumlah' => 9, 'percent' => '75%'],
                ['kode' => 'E78.0', 'nama' => 'Hiperkolesterolemia murni', 'jumlah' => 5, 'percent' => '41.6%'],
                ['kode' => 'E11', 'nama' => 'Diabetes melitus tipe 2', 'jumlah' => 4, 'percent' => '33.3%'],
                ['kode' => 'K00', 'nama' => 'Gangguan perkembangan dan erupsi gigi', 'jumlah' => 4, 'percent' => '33.3%'],
                ['kode' => 'J03', 'nama' => 'Tonsilitis akut', 'jumlah' => 4, 'percent' => '33.3%'],
                ['kode' => 'E79.0', 'nama' => 'Hiperurisemia tanpa tanda artritis inflamasi', 'jumlah' => 4, 'percent' => '33.3%'],
                ['kode' => 'J00', 'nama' => 'Nasofaringitis akut [common cold]', 'jumlah' => 3, 'percent' => '25%'],
                ['kode' => 'M10', 'nama' => 'Gout', 'jumlah' => 2, 'percent' => '16.6%'],
                ['kode' => 'K02', 'nama' => 'Karies gigi', 'jumlah' => 2, 'percent' => '16.6%'],
            ]
        ];

        return $this->view('statistik', $data);
    }
}
