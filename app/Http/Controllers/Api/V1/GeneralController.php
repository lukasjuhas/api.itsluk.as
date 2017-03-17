<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;

class GeneralController extends ApiController
{
    /**
     * show general information
     * 
     * @return mixed
     */
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
