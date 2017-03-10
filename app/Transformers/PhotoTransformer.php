<?php

namespace Transformers;

class PhotoTransformer extends Transformer
{
    public function transform($photo)
    {
        return [
            'id' => $photo['id'],
            'title' => $photo['title'],
            'thumb' => $photo['thumb'],
            'url' => $photo['url'],
            'caption' => $photo['caption'],
            'orientation' => $photo['orientation'],
            'data' => $photo['data'],
        ];
    }
}
