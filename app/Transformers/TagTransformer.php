<?php

namespace Transformers;

class TagTransformer extends Transformer
{
    /**
     * transform tag
     * 
     * @param array $tag
     * @return array
     */
    public function transform($tag)
    {
        return [
            'tag' => $tag['name'],
        ];
    }
}
