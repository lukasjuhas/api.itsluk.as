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
        if (!$query) {
            return false;
        }
        $endpoint = 'https://api.spotify.com/v1/search?q=' . $query . '&type=album,artist';
        $response = file_get_contents($endpoint);
        $response = json_decode($response, true);

        // simply return first item as our search should be quite precise
        return count($response['albums']['items']) ? $response['albums']['items'][0] : false;
    }

    /**
     * get track from based on album id
     * @param  Int $albumId
     * @return mixed
     */
    public function getTracks($albumId)
    {
        if (!$albumId) {
            return false;
        }

        $endpoint = 'https://api.spotify.com/v1/albums/' . $albumId . '/tracks?limit=50';
        $response = file_get_contents($endpoint);
        $response = json_decode($response, true);

        return $response;
    }

    /**
     * get preview tracks
     * @param  Int $albumId
     * @return Array
     */
    public function getPreviewTracks($albumId)
    {
        if (!$albumId) {
            return false;
        }

        $response = $this->getTracks($albumId);

        $ids = [];
        foreach ($response['items'] as $key => $track) {
            $ids[$key]['title'] = $track['name'];
            $ids[$key]['preview'] = $track['preview_url'];
        }

        return $ids;
    }
}
