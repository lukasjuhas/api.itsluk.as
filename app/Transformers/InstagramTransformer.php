<?php

namespace Transformers;

class InstagramTransformer extends Transformer
{
    /**
     * transform photo
     *
     * @param array $post
     * @return array
     */
    public function transform($post)
    {
        return [
            'link' => $post['link'],
            'thumb' => $post['images']['standard_resolution']['url'],
            'caption' => $post['caption']['text'],
        ];
    }
}
