<?php

namespace Transformers;

abstract class Transformer
{
    public function transformCollection(array $items)
    {
        // print_r($items); die();
        return array_map([$this, 'transform'], $items);
    }

    abstract public function transform($item);
}
