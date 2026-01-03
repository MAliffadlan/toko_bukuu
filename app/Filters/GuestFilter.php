<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GuestFilter implements FilterInterface
{
    /**
     * Redirect user yang sudah login jika mencoba akses halaman login/register
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if ($session->get('isLoggedIn')) {
            $role = $session->get('role');
            
            // Redirect berdasarkan role
            if (in_array($role, ['admin', 'staff'])) {
                return redirect()->to('/admin/dashboard');
            }
            
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah response
    }
}
