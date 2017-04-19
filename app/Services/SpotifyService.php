<?php
namespace Services;

class SpotifyService
{
    protected $api = 'https://api.spotify.com/v1/';

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

        $response = $this->call('search', [
            'q' => $query,
            'type' => 'album,artist'
        ]);

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

        $response = $this->call('albums/' . $albumId . '/tracks', [
            'limit' => 50
        ]);

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

    /**
     * call an endpoint with aprams
     * @param  string $endpoint
     * @param  array  $params
     * @return string
     */
    private function call($endpoint = '', $params = [])
    {
        $url = $this->endpoint($endpoint, $params);
        $response = file_get_contents($url);

        return json_decode($response, true);
    }

    /**
     * build endpoint
     * @param  string $endpoint
     * @param  array  $params
     * @return string
     */
    private function endpoint($endpoint = '', $params = [])
    {
        $formatted_params = $params ? '?' . http_build_query($params) : '';
        return $this->api . ltrim(rtrim($endpoint, '/'), '/') . $formatted_params;
    }
}
