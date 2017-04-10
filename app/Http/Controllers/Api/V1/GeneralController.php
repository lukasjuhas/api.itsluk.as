<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;
use Services\InstagramService as Instagram;

class GeneralController extends ApiController
{
    /**
     * Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->instagramTransformer = app(\Transformers\InstagramTransformer::class);
        $this->instagram = app(Instagram::class);
    }

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

    /**
     * get recent instagram posts
     *
     * @return mixed
     */
    public function getRecentInstagramPosts()
    {
        $posts = $this->instagram->getRecent();

        if (!$posts) {
            return $this->respondNotFound('Cannot fetch latest posts from Instagram.');
        }

        return $this->respond([
            'data' => $this->instagramTransformer->transformCollection($posts),
        ]);
    }
}
