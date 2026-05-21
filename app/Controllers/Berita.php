<?php

namespace App\Controllers;

class Berita extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Berita Terkini - PKM Balangnipa',
        ];
        return view('frontend/berita/index', $data);
    }

    public function detail(): string
    {
        $data = [
            'title' => 'Detail Berita - PKM Balangnipa',
        ];
        return view('frontend/berita/detail', $data);
    }
}
