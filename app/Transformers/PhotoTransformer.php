<?php

namespace Transformers;

class PhotoTransformer extends Transformer
{
    public function transform($photo)
    {
        return [
            'photo_title' => $photo['title'],
            'photo_url' => $photo['url'],
            'photo_data' => $photo['data'],
        ];
    }
}
