<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $info = [
            'name' => 'Lukas Juhas',
            'website' => 'https://itsluk.as',
            'email' => 'lukas@itsluk.as',
            'twitter' => '@itslukasjuhas'
        ];

        return response()->json($info);
    }
}
