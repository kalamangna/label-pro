<?php

namespace App\Controllers;

use App\Models\RecipientModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('landing');
    }

    public function dashboard(): string
    {
        $model = new RecipientModel();
        if (session()->get('role') !== 'admin') {
            $model->where('user_id', session()->get('user_id'));
        }
        $data = [
            'title' => 'Beranda',
            'totalRecipients' => $model->countAllResults(),
        ];
        return view('dashboard', $data);
    }
}
