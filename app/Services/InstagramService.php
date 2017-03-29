<?php
namespace Services;

class InstagramService
{

    /**
     * Get recent instagram posts
     *
     * @return mixed
     */
    public function getRecent()
    {
        $token = env('INSTAGRAM_ACCESS_TOKEN');
        $endpoint = 'https://api.instagram.com/v1/users/self/media/recent?access_token=' . $token;
        $response = file_get_contents($endpoint);
        $response = json_decode($response, true);

        return $response['data'];
    }
}
