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

        if ($request->input('content')) {
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
        $photos = $trip->photos->where('status', 'published');

        if (!$trip) {
            return $this->respondNotFound('Trip does not exists.');
        }

        if (empty($trip->content) && !$request->get('all')) {
            return $this->respondNotFound('Trip does not have any content.');
        }

        $content = (array) array_merge((array) $trip->toArray(), (array) $photos->toArray());

        return $this->respond([
            'data' => $this->tripTransformer->transform($content),
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

    /**
     * update a trip
     * @param Request $request
     * @param String $slug
     * @return mixed
     */
    public function update(Request $request, $slug)
    {
        $trip = Trip::where('slug', $slug)->first();

        if (!$trip) {
            return $this->respondNotFound('Trip does not exists.');
        }

        $update = $trip->update([
            'name' => $request->get('title'),
            'content' => $request->get('content'),
        ]);

        if ($update) {
            return $this->respondUpdated('Trip successfully updated.', $trip->id);
        }

        return $this->respondWithError('There was problem updating trip.');
    }

    /**
     * update a trip featured image
     * @param Request $request
     * @param String $slug
     * @return mixed
     */
    public function updateFeature(Request $request, $slug)
    {
        $trip = Trip::where('slug', $slug)->first();

        if (!$trip) {
            return $this->respondNotFound('Trip does not exists.');
        }

        $update = $trip->update([
            'feature' => $request->get('photo'),
        ]);

        if ($update) {
            return $this->respondUpdated('Trip feature successfully updated.', $trip->id);
        }

        return $this->respondWithError('There was problem updating trip feature.');
    }
}
