<?php

namespace Transformers;

class RecordTransformer extends Transformer
{
    public function transform($record)
    {
        return [
            'title' => $record->basic_information->title,
            'artist' => $record->basic_information->artists[0]->name,
            'year' => $record->basic_information->year
            // 'active' => (boolean) $record['some_bool'],
        ];
    }
}
