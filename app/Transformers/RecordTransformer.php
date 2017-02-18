<?php

namespace Transformers;

class RecordTransformer extends Transformer
{
    public function transform($record)
    {
        // print_r($record);
        return [
            'release_id' => $record->release_id,
            'title' => $record->basic_information->title,
            'artist' => $record->basic_information->artists[0]->name,
            'year' => $record->basic_information->year,
            'thumb' => $record->basic_information->thumb
        ];
    }
}
