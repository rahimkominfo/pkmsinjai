<?php

namespace App\Controllers\Frontend;

use App\Models\SdmPkmModel;

class SdmPkm extends BaseTenantController
{
    public function index()
    {
        $pkm_id = tenant()->pkm_id;
        $sdmModel = new SdmPkmModel();

        // Ambil filter dan pencarian dari request GET
        $search = $this->request->getGet('search');
        $unit_poli = $this->request->getGet('unit_poli');

        $builder = $sdmModel->where('pkm_id', $pkm_id);

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nama_lengkap', $search)
                    ->orLike('profesi_jabatan', $search)
                    ->groupEnd();
        }

        if (!empty($unit_poli)) {
            $builder->where('unit_poli', $unit_poli);
        }

        $listSdm = $builder->orderBy('nama_lengkap', 'ASC')->findAll();

        // Ambil daftar unik unit_poli untuk dropdown filter
        $units = $sdmModel->select('unit_poli')
                          ->where('pkm_id', $pkm_id)
                          ->groupBy('unit_poli')
                          ->orderBy('unit_poli', 'ASC')
                          ->findAll();

        $data = [
            'title' => 'Sumber Daya Manusia ' . tenant()->pkm_nama,
            'list_sdm' => $listSdm,
            'list_unit' => array_column($units, 'unit_poli'),
            'search' => $search,
            'selected_unit' => $unit_poli,
            'total_pegawai' => $sdmModel->where('pkm_id', $pkm_id)->countAllResults()
        ];

        return view('frontend/sdm/index', $data);
    }
}
