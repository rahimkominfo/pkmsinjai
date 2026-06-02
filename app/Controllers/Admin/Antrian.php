<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AntrianModel;
use App\Models\PeranModel;

class Antrian extends BaseAdminController
{
    protected $antrianModel;

    public function __construct()
    {
        $this->antrianModel = new AntrianModel();
    }

    public function index()
    {
        $pkm_id = tenant()->pkm_id;

        $data = [
            'title'   => 'Manajemen Antrian',
            'antrian' => $this->antrianModel->where('pkm_id', $pkm_id)->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC')->findAll()
        ];

        return view('admin/antrian/index', $data);
    }

    public function create()
    {
        $peranModel = new PeranModel();
        $peran = $peranModel->findAll();
        
        // Filter peran yang tidak relevan untuk loket antrian
        $peran = array_filter($peran, function($p) {
            return !in_array($p['nama_peran'], ['Admin Dinkes', 'Editor', 'Penulis']);
        });

        $data = [
            'title' => 'Tambah Antrian',
            'peran' => $peran
        ];
        return view('admin/antrian/form', $data);
    }

    public function store()
    {
        $rules = [
            'peran_id'=> 'required|numeric',
            'title'   => 'required|min_length[3]',
            'loket'   => 'required',
            'nomor'   => 'required',
            'petugas' => 'required',
            'status'  => 'required|in_list[menunggu,dilayani,selesai,batal]',
            'tanggal' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $pkm_id = tenant()->pkm_id;

        $this->antrianModel->insert([
            'pkm_id'  => $pkm_id,
            'peran_id'=> $this->request->getPost('peran_id') ?: null,
            'title'   => $this->request->getPost('title'),
            'loket'   => $this->request->getPost('loket'),
            'nomor'   => $this->request->getPost('nomor'),
            'petugas' => $this->request->getPost('petugas'),
            'status'  => $this->request->getPost('status'),
            'tanggal' => $this->request->getPost('tanggal'),
            'color'   => $this->request->getPost('color'),
            'icon'    => $this->request->getPost('icon')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $antrian = $this->antrianModel->find($id);

        if (!$antrian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data antrian tidak ditemukan');
        }

        $peranModel = new PeranModel();
        $peran = $peranModel->findAll();
        
        // Filter peran yang tidak relevan untuk loket antrian
        $peran = array_filter($peran, function($p) {
            return !in_array($p['nama_peran'], ['Admin Dinkes', 'Editor', 'Penulis']);
        });
        
        $data = [
            'title'   => 'Edit Antrian',
            'antrian' => $antrian,
            'peran'   => $peran
        ];

        return view('admin/antrian/form', $data);
    }

    public function update($id)
    {
        $antrian = $this->antrianModel->find($id);
        
        if (!$antrian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data antrian tidak ditemukan');
        }

        $rules = [
            'peran_id'=> 'required|numeric',
            'title'   => 'required|min_length[3]',
            'loket'   => 'required',
            'nomor'   => 'required',
            'petugas' => 'required',
            'status'  => 'required|in_list[menunggu,dilayani,selesai,batal]',
            'tanggal' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->antrianModel->update($id, [
            'peran_id'=> $this->request->getPost('peran_id') ?: null,
            'title'   => $this->request->getPost('title'),
            'loket'   => $this->request->getPost('loket'),
            'nomor'   => $this->request->getPost('nomor'),
            'petugas' => $this->request->getPost('petugas'),
            'status'  => $this->request->getPost('status'),
            'tanggal' => $this->request->getPost('tanggal'),
            'color'   => $this->request->getPost('color'),
            'icon'    => $this->request->getPost('icon')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil diupdate.');
    }

    public function delete($id)
    {
        if ($this->antrianModel->delete($id)) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', 'Data antrian berhasil dihapus.');
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('error', 'Gagal menghapus antrian.');
    }

    public function reset($id)
    {
        $antrian = $this->antrianModel->find($id);
        
        if (!$antrian) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('error', 'Gagal mereset, antrian tidak ditemukan.');
        }

        $nomor = trim($antrian['nomor']);
        // Regex extracts non-digit prefix and the digit part
        if (preg_match('/^(.*?)(\d+)$/', $nomor, $matches)) {
            $prefix = $matches[1];
            $digitLength = strlen($matches[2]);
            if ($digitLength < 3) $digitLength = 3;
            $newNomor = $prefix . str_repeat('0', $digitLength);
        } else {
            // Default padding if no numbers
            $newNomor = $nomor . '000';
        }

        $this->antrianModel->update($id, [
            'nomor' => $newNomor,
            'tanggal' => date('Y-m-d')
        ]);

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', "Nomor antrian {$antrian['title']} berhasil direset kembali menjadi {$newNomor} dan tanggal diupdate menjadi hari ini.");
    }

    public function updateStatus($id)
    {
        $antrian = $this->antrianModel->find($id);
        
        if (!$antrian) {
            return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('error', 'Gagal mengupdate status, antrian tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        
        if (in_array($status, ['menunggu', 'dilayani', 'selesai', 'batal'])) {
            $this->antrianModel->update($id, ['status' => $status]);
            
            // Catat log jika status menjadi selesai
            if ($status === 'selesai') {
                $logAntrianModel = new \App\Models\LogAntrianModel();
                
                // Ambil nomor antrian saat ini dan ekstrak total pengunjung (digit)
                $nomor = trim($antrian['nomor']);
                $total_pengunjung = 0;
                if (preg_match('/(\d+)$/', $nomor, $matches)) {
                    $total_pengunjung = (int)$matches[1];
                }
                
                // Cek apakah hari ini sudah ada log untuk antrian ini
                $existingLog = $logAntrianModel->where('antrian_id', $id)
                                               ->where('tanggal', $antrian['tanggal'])
                                               ->first();
                                               
                if ($existingLog) {
                    $logAntrianModel->update($existingLog['id'], [
                        'nomor_terakhir' => $nomor,
                        'total_pengunjung' => $total_pengunjung
                    ]);
                } else {
                    $logAntrianModel->insert([
                        'pkm_id' => $antrian['pkm_id'],
                        'antrian_id' => $antrian['id'],
                        'peran_id' => $antrian['peran_id'],
                        'title' => $antrian['title'],
                        'nomor_terakhir' => $nomor,
                        'total_pengunjung' => $total_pengunjung,
                        'tanggal' => $antrian['tanggal']
                    ]);
                }
            }

            return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('message', "Status antrian {$antrian['title']} berhasil diubah menjadi {$status}.");
        }

        return redirect()->to('admin/' . tenant()->pkm_slug . '/antrian')->with('error', 'Status tidak valid.');
    }
}
