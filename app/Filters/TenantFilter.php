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

        $hostname = $request->getUri()->getHost();
        $pkmModel = new PkmModel();
        
        // 1. Cek apakah hostname adalah domain utama portal
        $mainDomain = parse_url(base_url(), PHP_URL_HOST);
        
        $pkm = null;

        if ($hostname === $mainDomain || $hostname === 'localhost') {
            // Jika di domain utama, cek apakah ada segment (fallback mode)
            $slug = $request->getUri()->getSegment(1);
            
            // Jika diawali dengan 'admin', ambil segment berikutnya sebagai slug tenant
            if ($slug === 'admin') {
                $slug = $request->getUri()->getSegment(2);
            }
            
            if (empty($slug) || in_array($slug, ['login', 'logout', 'assets', 'uploads'])) {
                return; // Biarkan lolos untuk sistem utama
            }

            $pkm = $pkmModel->where('pkm_slug', $slug)->first();
        } else {
            // 2. Jika bukan domain utama, cari berdasarkan kolom pkm_domain
            $pkm = $pkmModel->where('pkm_domain', $hostname)->first();
        }

        if (!$pkm) {
            // Jika tidak ditemukan di domain utama dan bukan folder sistem, 
            // biarkan Routes yang menangani 404 jika perlu, atau lempar exception
            if ($hostname !== $mainDomain && $hostname !== 'localhost') {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tenant/Domain tidak terdaftar.');
            }
            return;
        }

        set_tenant($pkm);
        log_message('debug', 'Tenant detected in Filter: ' . $pkm['pkm_nama'] . ' with color: ' . ($pkm['primary_color'] ?? 'N/A'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
