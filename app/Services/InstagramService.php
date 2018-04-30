<?php
namespace Services;

class InstagramService
{
    protected $endpoint = 'https://api.instagram.com/v1';

    public function getRecent()
    {
        $token = env('INSTAGRAM_ACCESS_TOKEN');
        $endpoint = sprintf('%s/users/self/media/recent?access_token=%s', $this->endpoint, $token);
        $response = file_get_contents($endpoint);
        $response = json_decode($response, true);

        return $response['data'];
    }
}
