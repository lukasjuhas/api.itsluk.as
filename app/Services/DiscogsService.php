<?php
namespace Services;

class DiscogsService
{
    protected $api = 'https://api.discogs.com';

    /**
     * set client
     *
     * @return GuzzleHttp\Client
     */
    private function client()
    {
        return new Client([
            'base_uri' => $this->api,
            'headers' => [
                'User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * combine default and given query
     *
     * @param array $query
     * @return array
     */
    private function query($query = [])
    {
        $default = [
            'key' => env('DISCOGS_KEY'),
            'secret' => env('DISCOGS_SECRET')
        ];

        return ['query' => array_merge($default, $query)];
    }

    /**
     * parse response
     *
     * @param mixed $response
     * @return array
     */
    private function prase_reponse($response)
    {
        if (!$response) {
            return false;
        }

        return (array) json_decode($response->getBody());
    }
}
