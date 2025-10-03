<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        try {
            $this->session = \Config\Services::session();
        } catch (\Exception $e) {
            // Session not available, will handle in individual methods
            $this->session = null;
        }
    }

    public function register()
    {
        // Check if user is already logged in
        if ($this->session && $this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Set validation rules
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                // Hash the password
                $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                
                // Prepare user data
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password_hash' => $hashedPassword,
                    'role' => 'student'
                ];

                // Save user to database
                $insertId = $this->userModel->insert($userData);
                if ($insertId) {
                    // Auto-login the user after successful registration
                    if ($this->session) {
                        $sessionData = [
                            'user_id' => $insertId,
                            'name' => $userData['name'],
                            'email' => $userData['email'],
                            'role' => $userData['role'],
                            'is_logged_in' => true
                        ];
                        $this->session->set($sessionData);
                        $this->session->setFlashdata('success', 'Registration successful! Welcome, ' . $userData['name'] . '.');
                    }
                    return redirect()->to('/dashboard');
                } else {
                    if ($this->session) {
                        $this->session->setFlashdata('error', 'Registration failed. Please try again.');
                    }
                }
            }
        }

        $data['title'] = 'Register';
        return view('auth/register', $data);
    }

    public function login()
    {
        // Check if user is already logged in
        if ($this->session && $this->session->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Set validation rules
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Find user by email
                $user = $this->userModel->where('email', $email)->first();

                if ($user && password_verify($password, $user['password_hash'])) {
                    // Create user session
                    if ($this->session) {
                        $sessionData = [
                            'user_id' => $user['id'],
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'role' => $user['role'],
                            'is_logged_in' => true
                        ];
                        
                        $this->session->set($sessionData);
                        $this->session->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                    }
                    return redirect()->to('/dashboard');
                } else {
                    if ($this->session) {
                        $this->session->setFlashdata('error', 'Invalid email or password.');
                    }
                }
            }
        }

        $data['title'] = 'Login';
        return view('auth/login', $data);
    }

    public function logout()
    {
        // Destroy the session
        if ($this->session) {
            $this->session->destroy();
            $this->session->setFlashdata('success', 'You have been logged out successfully.');
        }
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        $userData = [
            'name'  => $this->session ? ($this->session->get('name')  ?? 'Guest User') : 'Guest User',
            'email' => $this->session ? ($this->session->get('email') ?? 'guest@example.com') : 'guest@example.com',
            'role'  => $this->session ? ($this->session->get('role')  ?? 'guest') : 'guest',
        ];

        $data = [
            'title' => 'Dashboard',
            'user'  => $userData,
        ];

        return view('auth/dashboard', $data);
    }
}
