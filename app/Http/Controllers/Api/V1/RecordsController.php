<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Transformers\RecordTransformer;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Request;
use Services\SpotifyService as Spotify;

class RecordsController extends ApiController
{
    /**
    * @var Transformers\RecordTransformer
    */
    protected $recordTransformer;

    protected $baseApiUri = 'https://api.discogs.com';

    public function __construct(RecordTransformer $recordTransformer)
    {
        $this->recordTransformer = $recordTransformer;
        $this->spotify = app(Spotify::class);
    }

    /**
     * get records
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->get('page')) {
            $response = $this->client()->request('GET', 'users/itslukas/collection', $this->query([
                'page' => $request->get('page'),
                'per_page' => 25
            ]));
        } else {
            $response = $this->client()->request('GET', 'users/itslukas/collection', $this->query([
                'per_page' => 25,
            ]));
        }

        $response_body = $this->prase_reponse($response);
        $items = $this->recordTransformer->transformCollection($response_body['releases']);

        // handle pagination (next)
        if (isset($response_body['pagination']->urls->next)) {
            $next_parse_url = parse_url($response_body['pagination']->urls->next);
            $next_parse = parse_str($next_parse_url['query'], $next);
        } else {
            $next = false;
        }

        // handle pagination (prev)
        if (isset($response_body['pagination']->urls->prev)) {
            $prev_parse_url = parse_url($response_body['pagination']->urls->prev);
            parse_str($prev_parse_url['query'], $prev);
        } else {
            $prev = false;
        }

        // response
        return $this->respond([
            'paginator' => [
                'total_count' => $response_body['pagination']->items,
                'total_pages' => $response_body['pagination']->pages,
                'current_page' => $response_body['pagination']->page,
                'limit' => $response_body['pagination']->per_page,
                'next_page' => $next['page'] ? 'https://api.itsluk.as/records?page=' . $next['page'] : null,
                'prev_page' => $prev['page'] ? 'https://api.itsluk.as/records?page=' . $prev['page'] : null,
            ],
            'data' => $items,
        ]);
    }

    /**
     * get single release
     *
     * @param Request $request
     * @param int $release
     * @return mixed
     */
    public function getRelease(Request $request, $release)
    {
        // make sure release id is present
        if (!$release) {
            $this->respondWithValidationError('Sorry, could not find release identifier.');
        }

        // get response and parse it
        $response = $this->client()->request('GET', 'https://api.discogs.com/releases/' . $release, $this->query());
        $parsed_response = $this->prase_reponse($response);

        // create encoded search query for spotify and search through spotify
        $encodedSearchQuery = 'album:' . $parsed_response['title'] . ' ' . 'artist:' . $parsed_response['artists'][0]->name;
        $spotify = $this->spotify->search(urlencode($encodedSearchQuery));
        $spotifyTracks = $this->spotify->getPreviewTracks($spotify['id']);

        $parsed_response['track_previews'] = $spotifyTracks;

        // add spotify url to the parsed response if there is result
        $parsed_response['spotify'] = $spotify ? $spotify['external_urls']['spotify'] : false;

        // run it trough transformer
        $item = $this->recordTransformer->transformRelease($parsed_response);

        // response
        return $this->respond([
            'data' => $item,
        ]);
    }
}
