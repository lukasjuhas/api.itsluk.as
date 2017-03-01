<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Trip;

class TripsController extends ApiController
{
    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tripTransformer = app(\Transformers\TripTransformer::class);
    }

    /**
     * get feed of trips
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? : 10;
        if ($limit > 100) {
            $limit = 100;
        }

        $trips = Trip::orderBy('id', 'desc')->paginate($limit);

        if($request->input('content')) {
            $trips = Trip::where('content', '!=', '')->orderBy('id', 'desc')->paginate($limit);
        } else {
            $trips = Trip::orderBy('id', 'desc')->paginate($limit);
        }

        // dd(get_class_methods($trips));

        return $this->respondWithPagination($trips, [
            'data' => $this->tripTransformer->transformCollection($trips->all())
        ]);
    }

    /**
     * show specific trip based on given id
     * @param $id
     * @return mixed
     */
    public function show(Request $request, $slug)
    {
        $trip = Trip::where('slug', $slug)->first();

        if (!$trip) {
            return $this->respondNotFound('Trip does not exists.');
        }

        if (empty($trip->content) && !$request->get('all')) {
            return $this->respondNotFound('Trip does not have any content.');
        }

        return $this->respond([
            'data' => $this->tripTransformer->transform($trip),
        ]);
    }

    /**
     * store a new trip
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $slug)
    {
        $trip = Trip::where('slug', $slug)->first();

        if(!$trip) {
            return $this->respondNotFound('Trip does not exists.');
        }

        $update = $trip->update([
            'name' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        if($update) {
            return $this->respondUpdated($trip->id);
        }

        return $this->respondWithError('There was problem updating trip.');
    }
}
