<?php
namespace Services;

use GuzzleHttp\Client;
use League\OAuth2\Client\Provider\GenericProvider;
use Carbon\Carbon;
use App\Setting;

class SpotifyService
{
    /**
     * base api uri
     * @var string
     */
    protected $api = 'https://api.spotify.com/v1/';

    /**
     * authorize url
     * @var string
     */
    protected $authorize_url = 'https://accounts.spotify.com/authorize';

    /**
     * token url
     * @var string
     */
    protected $token_url = 'https://accounts.spotify.com/api/token';

    /**
     * constructor
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
        $this->client_id = env('SPOTIFY_CLIENT');
        $this->client_secret = env('SPOTIFY_SECRET');
        $this->callback_url = env('SPOTIFY_CALLBACK_URL');
        $this->provider = new GenericProvider([
            'clientId'                => $this->client_id,    // The client ID assigned to you by the provider
            'clientSecret'            => $this->client_secret,   // The client password assigned to you by the provider
            'redirectUri'             => $this->callback_url,
            'urlAuthorize'            => $this->authorize_url,
            'urlAccessToken'          => $this->token_url,
            'urlResourceOwnerDetails' => '',
        ]);
    }

    /**
     * authorise
     * @return redirect
     */
    public function authorise()
    {
        $authorizationUrl = $this->provider->getAuthorizationUrl();
        $authorizationUrl = $authorizationUrl . '&scope=user-library-read';
        return redirect($authorizationUrl);
    }
    /**
     * handle code on callback
     * @return string
     */
    public function handleCode()
    {
        if (isset($_GET['code'])) {
            $this->setting->update_setting('spotify_code', $_GET['code']);
            $this->requestToken();
        }
        return $this->setting->get_setting('spotify_code');
    }
    /**
     * handle access token, if expired, refresh it
     * @return string
     */
    public function handleAccessToken()
    {
        $accessToken = $this->setting->get_setting('spotify_access_token');
        // echo $accessToken->expires; die();
        $not_expired = Carbon::createFromTimestamp($accessToken->expires);
        // if access token has expired, refresh it
        if (!$not_expired) {
            $accessToken = $this->refreshToken();
        }
        return $accessToken;
    }
    /**
     * request access token
     * @return object
     */
    public function requestToken()
    {
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $this->setting->get_setting('spotify_code'),
            ]);
            $this->setting->update_setting('spotify_access_token', $accessToken);
            return $accessToken;
        } catch (IdentityProviderException $e) {
        }
    }
    /**
     * refresh access token
     * @return object
     */
    public function refreshToken()
    {
        $accessToken = $this->setting->get_setting('spotify_access_token');
        return $this->provider->getAccessToken('refresh_token', [
            'refresh_token' => $accessToken->refresh_token
        ]);
    }

    /**
     * Search SpotifyService
     * @return mixed
     */
    public function search($query)
    {
        if (!$query) {
            return false;
        }

        $accessToken = $this->handleAccessToken();

        // search q
        $request = $this->client()->request('GET', 'search', [
            'query' => [
                'q' => $this->formatQuery($query),
                'type' => 'album,artist'
            ]
        ]);

        // parse
        $response = $this->prase_reponse($request);

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

        $request = $this->client()->request('GET', 'albums/' . $albumId . '/tracks', [
            'query' => [
                'limit' => 50
            ],
        ]);

        // parse
        $response = $this->prase_reponse($request);

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
     * set up client
     * @param  array  $options
     * @return boject
     */
    private function client()
    {
        return new Client($this->config());
    }

    /**
     * config
     * @param  object $stack
     * @return array
     */
    private function config()
    {
        $token = $this->handleAccessToken();

        return [
            'base_uri' => $this->api,
            'headers' => [
                'User-Agent' => sprintf('itsluk.as/1.0.0 + %s', env('APP_URL')),
                'Content-Type' => 'application/json',
                'Authorization' => sprintf('Bearer %s', $token->access_token),
            ],
        ];
    }

    /**
     * call an url with aprams
     * @param  string $endpoint
     * @param  array  $params
     * @return string
     */
    private function call($endpoint = '', $params = [])
    {
        $url = $this->url($endpoint, $params);
        $response = file_get_contents($url);

        return json_decode($response, true);
    }

    /**
     * build url
     * @param  string $endpoint
     * @param  array  $params
     * @return string
     */
    private function url($endpoint = '', $params = [])
    {
        $formatted_params = $params ? '?' . urldecode(http_build_query($params)) : '';
        return $this->api . ltrim(rtrim($endpoint, '/'), '/') . $formatted_params;
    }

    /**
     * parse response
     * @param mixed $response
     * @return array
     */
    private function prase_reponse($response)
    {
        if (!$response) {
            return false;
        }
        return json_decode($response->getBody(), true);
    }

    /**
     * format query
     * @param  string $query
     * @return string
     */
    private function formatQuery($query)
    {
        // remove some random discogs additions
        $query = str_replace(' (1)', '', $query);
        $query = str_replace(' (2)', '', $query);
        // to make sure we don't double "urlencode" which will cause in invalid
        // query
        return urldecode($query);
    }
}
