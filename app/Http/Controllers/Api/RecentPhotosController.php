<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Services\InstagramService as Instagram;
use Transformers\InstagramTransformer;
use Cache;

class RecentPhotosController extends ApiController
{
    public function index(Instagram $instagram, InstagramTransformer $instagramTransformer)
    {
        $posts = Cache::get('recentPhotos');
        
        if (!$posts) {
            try {
                $posts = $instagram->getRecent();

                if (!empty($posts)) {
                    Cache::put('recentPhotos', $posts, 60);
                }
            } catch (\Exception $e) {
                return $this->respondNotFound('Cannot fetch latest posts from Instagram.');
            }
        }

        if (!$posts) {
            return $this->respondNotFound('Cannot fetch latest posts from Instagram.');
        }

        return $this->respond([
            'data' => $instagramTransformer->transformCollection($posts),
        ]);
    }
}
