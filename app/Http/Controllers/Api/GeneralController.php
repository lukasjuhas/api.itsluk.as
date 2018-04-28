<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Cache;

class GeneralController extends ApiController
{
    public function index()
    {
        $data = [
            'data' => [
                'name' => 'Lukas Juhas',
                'website' => 'https://itsluk.as',
                'email' => 'lukas@itsluk.as',
                'twitter' => '@itslukasjuhas'
            ]
        ];

        $general = Cache::get('general');

        if (empty($general)) {
            Cache::put('general', $data, 60);
            $general = $data;
        }

        return $this->respond($general);
    }
}
