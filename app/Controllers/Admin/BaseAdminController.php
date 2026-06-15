<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PkmModel;

abstract class BaseAdminController extends Controller
{
    protected $request;
    protected $helpers = ['tenant', 'url'];
    protected $pkm;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper($this->helpers);

        // Format rute admin: /admin/slug-pkm/dashboard
        // Maka segment 1 adalah 'admin', segment 2 adalah slug tenant
        $slug = $this->request->getUri()->getSegment(2);

        if (empty($slug)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Akses Admin Ditolak: Tenant tidak disertakan di URL.');
        }

        // Boleh ada pengecualian 'super' untuk superadmin
        if ($slug === 'super') {
            set_tenant([
                'pkm_id' => 'super', 
                'pkm_slug' => 'super', 
                'pkm_nama' => 'Super Administrator',
                'primary_color' => '#1e293b', // Slate 800
                'on_primary_color' => '#f8fafc' // Slate 50
            ]);
            return;
        }

        $pkmModel = new PkmModel();
        $this->pkm = $pkmModel->where('pkm_slug', $slug)->first();

        if (!$this->pkm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan.');
        }

        set_tenant($this->pkm);
    }
}
