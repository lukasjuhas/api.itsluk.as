<?php

namespace Transformers;

class RecordTransformer extends Transformer
{
    /**
     * transform record
     *
     * @param array $record
     * @return array
     */
    public function transform($record)
    {
        return [
            'release_id' => $record->release_id,
            'title' => $record->basic_information->title,
            'artist' => $record->basic_information->artists[0]->name,
            'year' => $record->basic_information->year,
            'thumb' => $record->basic_information->thumb
        ];
    }

    /**
     * release transformer
     *
     * @param array $release
     * @return array
     */
    public function transformRelease($release)
    {
        $tracklist = [];
        foreach ($release['tracklist'] as $key => $track) {
            $tracklist[] = $track->title;
        }

        return [
            'title' => $release['title'],
            'artist' => $release['artists'][0]->name,
            'title' => $release['artists'][0]->name . ' - ' . $release['title'],
            'year' => $release['year'],
            'label' => $release['labels'][0]->name,
            'released' => $release['released'],
            'spotify' => $release['spotify'],
            'notes' => isset($release['notes']) ? $release['notes'] : false,
            'image' => $release['images'][0]->uri,
            'tracklist' => $tracklist,
        ];
    }
}
