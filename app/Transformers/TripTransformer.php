<?php

namespace Transformers;

class TripTransformer extends Transformer
{
    /**
     * transform tirp
     * 
     * @param array $trip
     * @return array
     */
    public function transform($trip)
    {
        $photos = [];

        foreach ($trip['photos'] as $key => $photo) {
            $size = unserialize($photo['size']);

            $photos[$key]['id'] = $photo['id'];
            $photos[$key]['title'] = $photo['title'];
            $photos[$key]['caption'] = $photo['caption'];
            $photos[$key]['thumb'] = $photo['thumb'];
            $photos[$key]['url'] = $photo['url'];
            $photos[$key]['width'] = $size['width'];
            $photos[$key]['height'] = $size['height'];
            $photos[$key]['orientation'] = $photo['orientation'];
            $photos[$key]['data'] = $photo['data'];
        }

        return [
            'title' => $trip['name'],
            'slug' => $trip['slug'],
            'location' => $trip['location'],
            'feature' => $trip['feature'],
            'upcoming' => (boolean) $trip['upcoming'],
            'content' => $trip['content'],
            'photos' => $photos,
        ];
    }
}
