<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;

class GeneralController extends ApiController
{
    public function index()
    {
        return $this->respond([
            'data' => [
                'name' => 'Lukas Juhas',
                'website' => 'https://itsluk.as',
                'email' => 'lukas@itsluk.as',
                'twitter' => '@itslukasjuhas'
            ]
        ]);
    }
}
