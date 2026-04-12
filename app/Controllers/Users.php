<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $this->userModel->findAll(),
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        $role = $this->request->getPost('role');
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'password' => 'required|min_length[5]',
            'role'     => 'required|in_list[admin,user]',
        ];

        if ($role === 'user') {
            $rules['package'] = 'required|in_list[basic,pro,unlimited]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $role,
            'package'  => $role === 'admin' ? 'basic' : $this->request->getPost('package'),
        ]);

        return redirect()->to('/users')->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $role = $this->request->getPost('role');
        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'role'     => 'required|in_list[admin,user]',
        ];

        if ($role === 'user') {
            $rules['package'] = 'required|in_list[basic,pro,unlimited]';
        }

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[5]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role'     => $role,
            'package'  => $role === 'admin' ? 'basic' : $this->request->getPost('package'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash((string)$password, PASSWORD_DEFAULT);
        }

        if (!$this->userModel->skipValidation()->update($id, $data)) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengguna. Silakan coba lagi.');
        }

        return redirect()->to('/users')->with('message', 'Pengguna berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Prevent deleting self
        if ($id == session()->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/users')->with('message', 'Pengguna berhasil dihapus.');
        }

        return redirect()->to('/users')->with('error', 'Gagal menghapus pengguna.');
    }
}
