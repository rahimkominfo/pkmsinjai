<?php

namespace App\Controllers;

use App\Models\PkmModel;

class Home extends BaseController
{
    public function index()
    {
        $pkmModel = new PkmModel();
        $data = [
            'pkms' => $pkmModel->findAll()
        ];
        
        return view('home', $data);
    }
}
