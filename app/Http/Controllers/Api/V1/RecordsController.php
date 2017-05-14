<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Transformers\RecordTransformer;
use Illuminate\Http\Request;
use Services\DiscogsService as Discogs;
use Services\SpotifyService as Spotify;

class RecordsController extends ApiController
{
    /**
    * @var Transformers\RecordTransformer
    */
    protected $recordTransformer;

    public function __construct(RecordTransformer $recordTransformer)
    {
        $this->recordTransformer = $recordTransformer;
        $this->discogs = app(Discogs::class);
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
            $response = $this->discogs->call('users/itslukas/collection', [
                'page' => $request->get('page'),
                'per_page' => 25
            ]);
        } else {
            $response = $this->discogs->call('users/itslukas/collection', [
                'per_page' => 25,
            ]);
        }

        $items = $this->recordTransformer->transformCollection($response['releases']);

        // handle pagination (next)
        if (isset($response['pagination']->urls->next)) {
            $next_parse_url = parse_url($response['pagination']->urls->next);
            $next_parse = parse_str($next_parse_url['query'], $next);
        } else {
            $next = false;
        }

        // handle pagination (prev)
        if (isset($response['pagination']->urls->prev)) {
            $prev_parse_url = parse_url($response['pagination']->urls->prev);
            parse_str($prev_parse_url['query'], $prev);
        } else {
            $prev = false;
        }

        // response
        return $this->respond([
            'paginator' => [
                'total_count' => $response['pagination']->items,
                'total_pages' => $response['pagination']->pages,
                'current_page' => $response['pagination']->page,
                'limit' => $response['pagination']->per_page,
                'next_page' => $next['page'] ? sprintf('%s/records?page=%s', url('/'), $next['page']) : null,
                'prev_page' => $prev['page'] ? sprintf('%s/records?page=%s', url('/'), $prev['page']) : null,
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
        $response = $this->discogs->call(sprintf('releases/%s', $release));

        // create encoded search query for spotify and search through spotify
        $encodedSearchQuery = sprintf('album:%s artist:%s', $response['title'], $response['artists'][0]->name);
        $spotify = $this->spotify->search(urlencode($encodedSearchQuery));
        $spotifyTracks = $this->spotify->getPreviewTracks($spotify['id']);

        $response['track_previews'] = $spotifyTracks;

        // add spotify url to the parsed response if there is result
        $response['spotify'] = $spotify ? $spotify['external_urls']['spotify'] : false;

        // run it trough transformer
        $item = $this->recordTransformer->transformRelease($response);

        // response
        return $this->respond([
            'data' => $item,
        ]);
    }
}
