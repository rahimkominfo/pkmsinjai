<?php

namespace App\Controllers\Frontend;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\PkmModel;

/**
 * Class BaseTenantController
 * 
 * Otomatis mendeteksi tenant berdasarkan URL segment pertama.
 * Mencegah duplikasi controller untuk setiap PKM.
 */
abstract class BaseTenantController extends Controller
{
    /**
     * Instance of the main Request object.
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon class instantiation.
     * @var array
     */
    protected $helpers = ['tenant', 'url'];

    /**
     * Menampung data tenant yang sedang aktif
     * @var array|object
     */
    protected $pkm;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load helpers
        helper($this->helpers);

        // 1. Dapatkan segment pertama dari URL (contoh: localhost/.../public/balangnipa)
        // Jika URI adalah /balangnipa/berita, maka segment(1) = 'balangnipa'
        $slug = $this->request->getUri()->getSegment(1);

        if (empty($slug)) {
            // Jika tidak ada tenant di URL, lempar 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak ditemukan di URL.');
        }

        // 2. Ambil data PKM dari database berdasarkan slug
        $pkmModel = new PkmModel();
        $this->pkm = $pkmModel->where('pkm_slug', $slug)->first();

        // 3. Jika tenant tidak ditemukan, tampilkan 404
        if (!$this->pkm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant PKM dengan slug "' . esc($slug) . '" tidak terdaftar.');
        }

        // 4. Set helper global agar bisa diakses di Model atau View dengan mudah: tenant()->pkm_id
        set_tenant($this->pkm);
    }
}
