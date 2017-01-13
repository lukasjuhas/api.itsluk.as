<?php

namespace Transformers;

class VinylTransformer extends Transformer
{
    public function transform($vinyl)
    {
        return [
            'title' => $vinyl->basic_information->title,
            'artist' => $vinyl->basic_information->artists[0]->name,
            // 'active' => (boolean) $vinyl['some_bool'],
        ];
    }
}
