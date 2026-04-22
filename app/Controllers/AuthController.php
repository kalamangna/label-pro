<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to dashboard or guests
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify((string)$password, $user['password'])) {
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'package'   => $user['package'] ?? 'basic',
                'logged_in' => true
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
    }

    public function startDemo()
    {
        $userModel = new UserModel();
        
        $randomSuffix = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $username = 'demo_' . $randomSuffix;
        $password = password_hash('demo' . $randomSuffix, PASSWORD_DEFAULT);

        // Generate a guest user and disable validation specifically for this quick insert if needed
        $userModel->insert([
            'username' => $username,
            'password' => $password,
            'role'     => 'demo',
        ]);

        $userId = $userModel->insertID();

        session()->set([
            'user_id'   => $userId,
            'username'  => 'Pengguna Demo',
            'role'      => 'demo',
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard')->with('message', 'Berhasil memulai mode demo. Data ini bersifat sementara dan hanya tersedia selama sesi browser Anda.');
    }

    public function logout()
    {
        $role = session()->get('role');
        session()->destroy();
        
        if ($role === 'demo') {
            return redirect()->to('/');
        }
        
        return redirect()->to('/login');
    }
}
