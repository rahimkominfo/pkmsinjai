<?php

namespace App\Controllers;

class Galeri extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Galeri Foto - PKM Balangnipa',
        ];
        return view('frontend/galeri/index', $data);
    }
}
