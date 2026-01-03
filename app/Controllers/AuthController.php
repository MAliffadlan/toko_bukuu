<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        return view('auth/login', [
            'title' => 'Login - Toko Buku'
        ]);
    }

    /**
     * Proses login
     */
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        $messages = [
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak terdaftar.');
        }

        if (!$this->userModel->verifyPassword($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah.');
        }

        // Set session
        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect berdasarkan role
        $redirectUrl = session()->get('redirect_url');
        session()->remove('redirect_url');

        if ($redirectUrl) {
            return redirect()->to($redirectUrl)->with('success', 'Selamat datang, ' . $user['username'] . '!');
        }

        if (in_array($user['role'], ['admin', 'staff'])) {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . $user['username'] . '!');
        }

        return redirect()->to('/browser')->with('success', 'Selamat datang, ' . $user['username'] . '!');
    }

    /**
     * Tampilkan halaman register
     */
    public function register()
    {
        return view('auth/register', [
            'title' => 'Daftar - Toko Buku'
        ]);
    }

    /**
     * Proses registrasi
     */
    public function attemptRegister()
    {
        $rules = [
            'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'username' => [
                'required'   => 'Username wajib diisi.',
                'min_length' => 'Username minimal 3 karakter.',
                'is_unique'  => 'Username sudah digunakan.',
            ],
            'email' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique'   => 'Email sudah terdaftar.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password'      => $this->request->getPost('password'),
            'role'          => 'customer', // Default role
        ];

        if ($this->userModel->insert($userData)) {
            return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        }

        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
}
