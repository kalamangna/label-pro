<?php

namespace App\Controllers;

use App\Models\GuestModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('landing');
    }

    public function dashboard(): string
    {
        $guestModel = new GuestModel();
        $eventModel = new \App\Models\EventModel();

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));

        if (session()->get('role') !== 'admin') {
            $guestModel->where('user_id', session()->get('user_id'));
            $eventModel->where('user_id', session()->get('user_id'));
        }

        $data = [
            'title'           => 'Dashboard',
            'totalGuests' => $guestModel->countAllResults(),
            'totalEvents'     => $eventModel->countAllResults(),
            'totalUsers'      => session()->get('role') === 'admin' ? (new \App\Models\UserModel())->countAllResults() : 0,
            'limits'          => $limits,
            'package'         => $package,
        ];
        return view('dashboard', $data);
    }

    public function panduan()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/dashboard');
        }
        return view('panduan', ['title' => 'Panduan Penggunaan']);
    }
}
