<?php

namespace App\Controllers\Admin;

use App\Models\StatistikPenyakitModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Statistik extends BaseAdminController
{
    protected $statistikModel;

    public function __construct()
    {
        $this->statistikModel = new StatistikPenyakitModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $periode = $this->request->getGet('periode');

        $query = $this->statistikModel->where('pkm_id', $pkm_id);
        
        if ($periode) {
            $parts = explode('|', $periode);
            if (count($parts) === 2) {
                $query->where('periode_awal', $parts[0])
                      ->where('periode_akhir', $parts[1]);
            }
        }

        $statistik = $query->orderBy('periode_awal', 'DESC')->orderBy('total', 'DESC')->findAll();

        // Get distinct periods for filter
        $list_periode = $this->statistikModel->select('periode_awal, periode_akhir')
                                            ->where('pkm_id', $pkm_id)
                                            ->groupBy('periode_awal, periode_akhir')
                                            ->orderBy('periode_awal', 'DESC')
                                            ->findAll();

        $data = [
            'title' => 'Statistik Penyakit - ' . tenant()->pkm_nama,
            'statistik' => $statistik,
            'list_periode' => $list_periode,
            'filter_periode' => $periode,
            'active_menu' => 'statistik'
        ];

        return view('admin/statistik/index', $data);
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = $file->getClientExtension();
            if (!in_array($ext, ['xlsx', 'xls'])) {
                return redirect()->back()->with('error', 'Format file tidak valid. Gunakan .xlsx atau .xls');
            }

            try {
                $spreadsheet = IOFactory::load($file->getTempName());
                $worksheet = $spreadsheet->getActiveSheet();
                
                // Get Metadata
                $pkm_name_excel = $worksheet->getCell('B2')->getValue();
                $periode_raw = $worksheet->getCell('B3')->getValue(); // Format: 01-05-2026 - 31-05-2026
                
                $periode_parts = explode(' - ', $periode_raw);
                $periode_awal = null;
                $periode_akhir = null;
                
                if (count($periode_parts) == 2) {
                    $periode_awal = date('Y-m-d', strtotime($periode_parts[0]));
                    $periode_akhir = date('Y-m-d', strtotime($periode_parts[1]));
                }

                $data_to_insert = [];
                $highestRow = $worksheet->getHighestRow();

                // Rows start from 8 (index 7 is the first data row based on inspection)
                for ($row = 8; $row <= $highestRow; $row++) {
                    $no = $worksheet->getCell('A' . $row)->getValue();
                    if (empty($no)) continue;

                    $kode = $worksheet->getCell('B' . $row)->getValue();
                    $diagnosa = $worksheet->getCell('C' . $row)->getValue();
                    $lk = (int)$worksheet->getCell('D' . $row)->getValue();
                    $pr = (int)$worksheet->getCell('E' . $row)->getValue();
                    $total = (int)$worksheet->getCell('F' . $row)->getValue();

                    $data_to_insert[] = [
                        'pkm_id' => tenant()->pkm_id,
                        'kode_diagnosa' => $kode,
                        'diagnosa' => $diagnosa,
                        'jumlah_lk' => $lk,
                        'jumlah_pr' => $pr,
                        'total' => $total,
                        'periode_awal' => $periode_awal,
                        'periode_akhir' => $periode_akhir,
                    ];
                }

                if (!empty($data_to_insert)) {
                    // Optional: Clear existing data for this period and PKM to avoid duplicates if re-importing
                    $this->statistikModel->where('pkm_id', tenant()->pkm_id)
                                        ->where('periode_awal', $periode_awal)
                                        ->where('periode_akhir', $periode_akhir)
                                        ->delete(null, true); // Hard delete for re-import

                    $this->statistikModel->insertBatch($data_to_insert);
                    return redirect()->back()->with('success', 'Data berhasil diimport: ' . count($data_to_insert) . ' baris.');
                } else {
                    return redirect()->back()->with('error', 'Tidak ada data yang ditemukan di file.');
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Silakan pilih file Excel.');
    }
}
