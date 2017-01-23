<?php

namespace Transformers;

class TagTransformer extends Transformer
{
    public function transform($tag)
    {
        return [
            'tag' => $tag['name'],
        ];
    }
}
