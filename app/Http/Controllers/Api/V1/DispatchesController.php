<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Dispatch;

class DispatchesController extends ApiController
{
    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->dispatchTransformer = app(\Transformers\DispatchTransformer::class);
    }

    public function index()
    {
        $dispatches = Dispatch::all();

        return $this->respond([
            'data' => $this->dispatchTransformer->transformCollection($dispatches->toArray()),
        ]);
    }

    public function show($id)
    {
        $dispatch = Dispatch::find($id);

        if(!$dispatch) {
            return $this->respondNotFound('Dispatch does not exists.');
        }

        return $this->respond([
            'data' => $this->dispatchTransformer->transform($dispatch),
        ]);
    }

    public function store(Request $request)
    {
        if(!$request->input('title') or !$request->input('content'))
        {
            $this->respondWithValidationError('Parameters failed validation for a dispatch.');
        }

        Dispatch::create($request->all());

        return $this->respondCreated('Dispatch successfully created.');
    }
}
