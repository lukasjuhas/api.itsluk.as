<?php

namespace App\Http\Controllers;

class GeneralController extends Controller
{
    public function index()
    {
        return $this->respond([
            'name' => 'Lukas Juhas',
            'url' => 'https://itsluk.as',
            'email' => 'lukas@itsluk.as',
            'twitter' => '@itslukasjuhas'
        ]);
    }
}
