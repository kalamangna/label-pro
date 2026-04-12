<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\RecipientModel;
use CodeIgniter\HTTP\ResponseInterface;

class Projects extends BaseController
{
    protected $projectModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
    }

    private function applyScope($model = null)
    {
        $model = $model ?? $this->projectModel;
        if (session()->get('role') !== 'admin') {
            return $model->where('projects.user_id', session()->get('user_id'));
        }
        return $model;
    }

    private function checkOwnership($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->projectModel->find($id);
        }
        return $this->projectModel->where('projects.user_id', session()->get('user_id'))->find($id);
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $userIdFilter = $this->request->getGet('user_id') ?? '';
        $sort = $this->request->getGet('sort') ?? 'id';
        $dir = $this->request->getGet('dir') ?? 'desc';

        $model = $this->applyScope();
        
        $model = $model->select('projects.*, users.username as added_by')
                       ->join('users', 'users.id = projects.user_id', 'left');

        if (!empty($search)) {
            $model = $model->like('projects.name', $search);
        }

        if (session()->get('role') === 'admin' && !empty($userIdFilter)) {
            $model = $model->where('projects.user_id', $userIdFilter);
        }

        $allowedSort = ['id', 'name', 'created_at'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $qualifiedSort = 'projects.' . $sort;
        
        if ($sort === 'id') {
            $dir = 'desc';
        } else {
            $dir = strtolower($dir) === 'desc' ? 'desc' : 'asc';
        }

        $model = $model->orderBy($qualifiedSort, $dir);

        $users = [];
        if (session()->get('role') === 'admin') {
            $userModel = new \App\Models\UserModel();
            $users = $userModel->findAll();
        }

        $data = [
            'title'    => 'Daftar Proyek',
            'projects' => $model->paginate(10),
            'pager'    => $model->pager,
            'search'   => $search,
            'userIdFilter' => $userIdFilter,
            'sort'     => $sort,
            'dir'      => $dir,
            'users'    => $users,
        ];

        return view('projects/index', $data);
    }

    public function store()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/projects')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentProjectsCount = $this->projectModel->where('user_id', session()->get('user_id'))->countAllResults();
        
        if ($currentProjectsCount >= $limits['max_projects']) {
            return redirect()->back()->withInput()->with('error', "Anda telah mencapai batas maksimal proyek untuk {$limits['name']} ({$limits['max_projects']} proyek). Silakan hubungi admin untuk upgrade.");
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->projectModel->save([
            'user_id' => session()->get('user_id'),
            'name'    => $this->request->getPost('name'),
        ]);

        return redirect()->to('/projects')->with('message', 'Proyek berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/projects')->with('error', 'Admin hanya dapat melihat data.');
        }

        $project = $this->checkOwnership($id);
        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Proyek tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->projectModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/projects')->with('message', 'Proyek berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/projects')->with('error', 'Admin hanya dapat melihat data.');
        }

        $project = $this->checkOwnership($id);
        if ($project) {
            $this->projectModel->delete($id);
            return redirect()->to('/projects')->with('message', 'Proyek berhasil dihapus.');
        }
        return redirect()->to('/projects')->with('error', 'Proyek tidak ditemukan.');
    }
}
