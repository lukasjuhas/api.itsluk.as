<?php

namespace Transformers;

class TripTransformer extends Transformer
{
    public function transform($trip)
    {
        return [
            'title' => $trip['name'],
            'location' => $trip['location'],
            'feature' => $trip['feature'],
            'upcoming' => (boolean) $trip['upcoming'],
        ];
    }
}
