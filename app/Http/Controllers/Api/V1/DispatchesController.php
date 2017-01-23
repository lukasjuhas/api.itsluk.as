<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Dispatch;

class DispatchesController extends Controller
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

        return Dispatch::all();
    }
}
