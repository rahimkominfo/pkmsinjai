<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Enforce tenant isolation
        $requestSlug = $request->getUri()->getSegment(2);
        $userRole = session()->get('peran');
        $userSlug = session()->get('pkm_slug');

        if ($userRole !== 'Admin Dinkes' && $requestSlug !== $userSlug && $requestSlug !== 'dashboard' && $requestSlug !== 'super') {
            return redirect()->to('/admin/' . $userSlug . '/dashboard')->with('error', 'Anda tidak memiliki akses ke tenant ini.');
        }
        
        // Cek roles jika ada
        if ($arguments) {
            $userRole = session()->get('peran');
            if (!in_array($userRole, $arguments)) {
                $pkmSlug = session()->get('pkm_slug') ?? 'super';
                // Return 403 or redirect
                return redirect()->to('/admin/' . $pkmSlug . '/dashboard')->with('error', 'Akses ditolak.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
