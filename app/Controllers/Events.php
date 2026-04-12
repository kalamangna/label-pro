<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\RecipientModel;
use CodeIgniter\HTTP\ResponseInterface;

class Events extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    private function applyScope($model = null)
    {
        $model = $model ?? $this->eventModel;
        if (session()->get('role') !== 'admin') {
            return $model->where('events.user_id', session()->get('user_id'));
        }
        return $model;
    }

    private function checkOwnership($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->eventModel->find($id);
        }
        return $this->eventModel->where('events.user_id', session()->get('user_id'))->find($id);
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $userIdFilter = $this->request->getGet('user_id') ?? '';
        $sort = $this->request->getGet('sort') ?? 'id';
        $dir = $this->request->getGet('dir') ?? 'desc';

        $model = $this->applyScope();
        
        $model = $model->select('events.*, users.username as added_by')
                       ->join('users', 'users.id = events.user_id', 'left');

        if (!empty($search)) {
            $model = $model->like('events.name', $search);
        }

        if (session()->get('role') === 'admin' && !empty($userIdFilter)) {
            $model = $model->where('events.user_id', $userIdFilter);
        }

        $allowedSort = ['id', 'name', 'created_at'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $qualifiedSort = 'events.' . $sort;
        
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
            'title'    => 'Daftar Acara',
            'events'   => $model->paginate(10),
            'pager'    => $model->pager,
            'search'   => $search,
            'userIdFilter' => $userIdFilter,
            'sort'     => $sort,
            'dir'      => $dir,
            'users'    => $users,
        ];

        return view('events/index', $data);
    }

    public function store()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/events')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentEventsCount = $this->eventModel->where('user_id', session()->get('user_id'))->countAllResults();
        
        if ($currentEventsCount >= $limits['max_events']) {
            return redirect()->back()->withInput()->with('error', "Anda telah mencapai batas maksimal acara untuk {$limits['name']} ({$limits['max_events']} acara). Silakan hubungi admin untuk upgrade.");
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->eventModel->save([
            'user_id' => session()->get('user_id'),
            'name'    => $this->request->getPost('name'),
        ]);

        return redirect()->to('/events')->with('message', 'Acara berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/events')->with('error', 'Admin hanya dapat melihat data.');
        }

        $event = $this->checkOwnership($id);
        if (!$event) {
            return redirect()->to('/events')->with('error', 'Acara tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->eventModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/events')->with('message', 'Acara berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/events')->with('error', 'Admin hanya dapat melihat data.');
        }

        $event = $this->checkOwnership($id);
        if ($event) {
            $this->eventModel->delete($id);
            return redirect()->to('/events')->with('message', 'Acara berhasil dihapus.');
        }
        return redirect()->to('/events')->with('error', 'Acara tidak ditemukan.');
    }
}
