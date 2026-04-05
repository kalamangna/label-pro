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
        $data = [
            'title' => 'Beranda',
            'totalRecipients' => $model->countAllResults(),
        ];
        return view('welcome_message', $data);
    }
}
