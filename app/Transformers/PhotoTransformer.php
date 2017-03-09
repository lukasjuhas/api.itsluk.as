<?php

namespace Transformers;

class PhotoTransformer extends Transformer
{
    public function transform($photo)
    {
        return [
            'title' => $photo['title'],
            'thumb' => $photo['thumb'],
            'url' => $photo['url'],
            'caption' => $photo['caption'],
            'data' => $photo['data'],
        ];
    }
}
