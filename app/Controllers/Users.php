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
            'role'     => 'required|in_list[admin,user,demo]',
        ];

        if ($role === 'user') {
            $rules['package'] = 'required|in_list[basic,pro,unlimited]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username'       => $this->request->getPost('username'),
            'password'       => password_hash((string)$this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => $role,
            'package'        => $role === 'user' ? $this->request->getPost('package') : null,
            'payment_status' => $role === 'user' ? 'belum' : null,
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
            'role'     => 'required|in_list[admin,user,demo]',
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
            'username'       => $this->request->getPost('username'),
            'role'           => $role,
            'package'        => $role === 'user' ? $this->request->getPost('package') : null,
            'payment_status' => $role === 'user' ? ($user['payment_status'] ?? 'belum') : null,
            'payment_proof'  => $role === 'user' ? ($user['payment_proof'] ?? null) : null,
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

    public function invoice($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        if ($user['role'] !== 'user') {
            return redirect()->to('/users')->with('error', 'Invoice hanya tersedia untuk akun pengguna standar.');
        }

        $packageLimits = UserModel::getPackageLimits($user['package'] ?? 'basic', $user['role']);
        
        $prices = [
            'basic'     => 50000,
            'pro'       => 150000,
            'unlimited' => 350000,
        ];

        $data = [
            'title'         => 'Invoice #' . str_pad($user['id'], 5, '0', STR_PAD_LEFT),
            'user'          => $user,
            'package_name'  => $packageLimits['name'],
            'price'         => $prices[$user['package'] ?? 'basic'] ?? 0,
            'invoice_no'    => 'INV/' . date('Ymd', strtotime($user['created_at'])) . '/' . str_pad($user['id'], 4, '0', STR_PAD_LEFT),
        ];

        return view('users/invoice', $data);
    }

    public function confirmPayment($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $rules = [
            'payment_proof' => 'uploaded[payment_proof]|max_size[payment_proof,2048]|is_image[payment_proof]|ext_in[payment_proof,png,jpg,jpeg,webp]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/users')->with('error', 'Gagal mengunggah bukti pembayaran. Pastikan file berupa gambar (maksimal 2MB).');
        }

        $file = $this->request->getFile('payment_proof');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/payments', $newName);
            
            $this->userModel->update($id, [
                'payment_status' => 'lunas',
                'payment_proof'  => 'uploads/payments/' . $newName,
            ]);

            return redirect()->to('/users')->with('message', 'Pembayaran berhasil dikonfirmasi.');
        }

        return redirect()->to('/users')->with('error', 'Terjadi kesalahan saat mengunggah file.');
    }
}
