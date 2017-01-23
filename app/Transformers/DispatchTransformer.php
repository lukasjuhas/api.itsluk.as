<?php

namespace Transformers;

class DispatchTransformer extends Transformer
{
    public function transform($dispatch)
    {
        return [
            'post_title' => $dispatch['title'],
            'post_content' => $dispatch['content'],
        ];
    }
}
