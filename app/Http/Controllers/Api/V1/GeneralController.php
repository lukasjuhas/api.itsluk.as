<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;

class GeneralController extends ApiController
{
    /**
     * show general information
     * @return mixed
     */
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
