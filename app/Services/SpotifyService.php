<?php
namespace Services;

class SpotifyService
{

    /**
     * Search spotify
     *
     * @return mixed
     */
    public function search($query)
    {
        $endpoint = 'https://api.spotify.com/v1/search?q=' . $query . '&type=album,artist';
        $response = file_get_contents($endpoint);
        $response = json_decode($response, true);

        // simply return first item as our search should be quite precise
        return count($response['albums']['items']) ? $response['albums']['items'][0] : false;
    }
}
