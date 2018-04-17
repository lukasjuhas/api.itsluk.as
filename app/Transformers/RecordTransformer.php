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
            'release_id' => $record->instance_id,
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
            $tracklist[$key]['title'] = $track->title;
            $tracklist[$key]['preview'] = $release['track_previews'] ? $this->matchClosestTrack($track->title, $release['track_previews']) : false;
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

    /**
     * match closest tracks
     * @param  String $value
     * @param  Array $haystack
     * @return String
     */
    private function matchClosestTrack($value, $haystack)
    {
        // no shortest distance found, yet
        $shortest = -1;

        // loop through haystack to find the closest
        foreach ($haystack as $item) {

            // calculate the distance between the value item,
            // and the current item
            $lev = levenshtein($value, $item['title']);

            // check for an exact match
            if ($lev == 0) {

                // closest item is this one (exact match)
                $closest = $item['preview'];
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest item has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                // set the closest match, and shortest distance
                $closest  = $item['preview'];
                $shortest = $lev;
            }
        }

        return $closest;
    }
}
