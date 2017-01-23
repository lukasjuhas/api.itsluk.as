<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Tag;
use App\Dispatch;

class TagsController extends ApiController
{
    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tagTransformer = app(\Transformers\TagTransformer::class);
    }

    public function index($dispatchId = null)
    {
        $tags = $this->getTags($dispatchId);

        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->toArray()),
        ]);
    }

    public function show($id)
    {
        $tag = Tag::find($id);

        if(!$tag) {
            return $this->respondNotFound('Tag does not exists.');
        }

        return $this->respond([
            'data' => $this->tagTransformer->transform($tag),
        ]);
    }

    public function store(Request $request)
    {
        if(!$request->input('title') or !$request->input('content'))
        {
            $this->respondWithValidationError('Parameters failed validation for a tag.');
        }

        Tag::create($request->all());

        return $this->respondCreated('Tag successfully created.');
    }

    private function getTags($dispatchId)
    {
        return $dispatchId ? Dispatch::findOrFail($dispatchId)->tags : Tag::all();
    }
}
