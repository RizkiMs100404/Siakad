<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $validation = \Config\Services::validation();

        // Validasi input form login
        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Email dan password tidak valid!');
        }

        $userModel = new UserModel();
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        // Cek user dan password
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Login gagal. Email atau password salah!');
        }

        // Set session dengan user_id dan atribut lain
        $session->set([
            'user_id'    => $user['id'],
            'user_foto'  => $user['foto'] ?? 'default.png',
            'username'   => $user['username'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        // Redirect berdasarkan role
        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'guru':
                return redirect()->to('/guru/dashboard');
            case 'siswa':
                return redirect()->to('/siswa/dashboard');
            default:
                return redirect()->to('/dashboard');
        }
    }

    public function register()
    {
        return redirect()->to('/login')->with('error', 'Registrasi dilakukan oleh admin.');
    }

    public function registerPost()
    {
        $validation = \Config\Services::validation();

        // Validasi input form register
        if (!$this->validate([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,guru,siswa]',
        ], [
            'email' => [
                'is_unique' => 'Email sudah digunakan.',
            ],
            'role' => [
                'in_list' => 'Role tidak valid.',
            ]
        ])) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ];

        $userModel->insert($data);

         return redirect()->to('/login')->with('error', 'Registrasi dilakukan oleh admin.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
