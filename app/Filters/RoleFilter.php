<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Security: Check if user has required role before allowing access
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in first
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Please login to access this page');
            return redirect()->to('/login');
        }

        // Get user role from session
        $userRole = session()->get('role');

        // If specific roles are required
        if ($arguments !== null && !empty($arguments)) {
            // Check if user has one of the required roles
            if (!in_array($userRole, $arguments)) {
                session()->setFlashdata('error', 'Access denied. You do not have permission to view this page.');
                return redirect()->to('/dashboard');
            }
        }
    }

    /**
     * No action needed after controller execution
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do here
    }
}
