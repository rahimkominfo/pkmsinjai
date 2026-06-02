<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PkmModel;

class TenantFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('tenant');

        // Jika Anda ingin menggunakan Route Filter alih-alih BaseTenantController,
        // Anda bisa mengaktifkan filter ini di app/Config/Filters.php.
        // Konsepnya sama: membaca segment URL, query database, set global helper.
        
        $slug = $request->getUri()->getSegment(1);

        if (empty($slug) || $slug === 'admin') {
            return; // Biarkan lolos untuk admin atau halaman utama portal
        }

        $pkmModel = new PkmModel();
        $pkm = $pkmModel->where('pkm_slug', $slug)->first();

        if (!$pkm) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant tidak valid.');
        }

        set_tenant($pkm);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
