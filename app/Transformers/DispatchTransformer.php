<?php

namespace Transformers;

class DispatchTransformer extends Transformer
{
    public function transform($post)
    {
        return [
            'post_title' => $post->title,
            'post_content' => $post->content,
        ];
    }
}
