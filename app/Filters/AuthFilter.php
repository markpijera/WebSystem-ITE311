<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Security: Check if user is authenticated before allowing access
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            // Store the intended URL to redirect after login
            session()->set('redirect_url', current_url());
            
            // Redirect to login with error message
            session()->setFlashdata('error', 'Please login to access this page');
            return redirect()->to('/login');
        }

        // Security: Validate session integrity
        if (!$this->validateSession()) {
            session()->destroy();
            session()->setFlashdata('error', 'Session expired or invalid. Please login again.');
            return redirect()->to('/login');
        }

        // If role-based access is required
        if ($arguments !== null && !empty($arguments)) {
            $userRole = session()->get('role');
            
            // Check if user has required role
            if (!in_array($userRole, $arguments)) {
                session()->setFlashdata('error', 'You do not have permission to access this page');
                return redirect()->to('/dashboard');
            }
        }
    }

    /**
     * Security: Perform actions after controller execution
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Add security headers
        $response->setHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->setHeader('X-Content-Type-Options', 'nosniff');
        $response->setHeader('X-XSS-Protection', '1; mode=block');
        $response->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        return $response;
    }

    /**
     * Security: Validate session integrity
     */
    private function validateSession()
    {
        // Check if session has required data
        if (!session()->has('userID') || !session()->has('login_time')) {
            return false;
        }

        // Security: Check session timeout (24 hours)
        $sessionTimeout = 86400; // 24 hours
        if ((time() - session()->get('login_time')) > $sessionTimeout) {
            return false;
        }

        return true;
    }
}
