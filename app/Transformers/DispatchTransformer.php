<?php

namespace Transformers;

class DispatchTransformer extends Transformer
{
    /**
     * transform dispatch
     * 
     * @param array $dispatch
     * @return array
     */
    public function transform($dispatch)
    {
        return [
            'post_title' => $dispatch['title'],
            'post_content' => $dispatch['content'],
        ];
    }
}
