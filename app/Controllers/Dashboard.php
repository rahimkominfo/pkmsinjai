<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'PKM Balangnipa - Beranda',
        ];
        return view('frontend/dashboard/index', $data);
    }
}
