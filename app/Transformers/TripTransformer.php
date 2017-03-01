<?php

namespace Transformers;

class TripTransformer extends Transformer
{
    public function transform($trip)
    {
        return [
            'title' => $trip['name'],
            'slug' => $trip['slug'],
            'location' => $trip['location'],
            'feature' => $trip['feature'],
            'upcoming' => (boolean) $trip['upcoming'],
            'content' => $trip['content'],
        ];
    }
}
