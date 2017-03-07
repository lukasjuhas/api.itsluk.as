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

    /**
     * get feed of dispatches
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? : 10;
        if ($limit > 100) {
            $limit = 100;
        }

        $dispatches = Dispatch::paginate($limit);

        // dd(get_class_methods($dispatches));

        return $this->respondWithPagination($dispatches, [
            'data' => $this->dispatchTransformer->transformCollection($dispatches->all())
        ]);
    }

    /**
     * show specific dispatch based on given id
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $dispatch = Dispatch::find($id);

        if (!$dispatch) {
            return $this->respondNotFound('Dispatch does not exists.');
        }

        return $this->respond([
            'data' => $this->dispatchTransformer->transform($dispatch),
        ]);
    }

    /**
     * store a new dispatch
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // validate user request
        $user = $this->getRequestingUser($request);
        if(!$user) {
            return $this->respondWithValidationError('Authentication failed validation for a dispatch.');
        }

        // validate fields
        if (!$request->has('title') or !$request->has('content')) {
            return $this->respondWithValidationError('Parameters failed validation for a dispatch.');
        }

        // create a dispatch
        $dispatch = Dispatch::create($request->all());

        if ($dispatch) {
            return $this->respondCreated('Dispatch successfully created.', $dispatch->id);
        }

        return $this->respondInternalError('There was a problem creating a new dispatch.');
    }
}
