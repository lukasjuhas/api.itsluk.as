<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;

use Transformers\RecordTransformer;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Request;

class RecordsController extends ApiController
{
    /**
    * @var Transformers\RecordTransformer
    */
    protected $recordTransformer;

    public function __construct(RecordTransformer $recordTransformer)
    {
        $this->recordTransformer = $recordTransformer;
    }

    /**
     * set client
     * @return GuzzleHttp\Client
     */
    private function client()
    {
        return new Client([
            'base_uri' => 'https://api.discogs.com',
            'headers' => [
                'User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as',
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * get records
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->get('page')) {
            $response = $this->client()->request('GET', 'users/itslukas/collection', [
                'query' => [
                    'page' => $request->get('page'),
                    'per_page' => 25,
                    'key' => env('DISCOGS_KEY'),
                    'secret' => env('DISCOGS_SECRET')
                ]
            ]);
        } else {
            $response = $this->client()->request('GET', 'users/itslukas/collection', [
                'query' => [
                    'per_page' => 25,
                    'key' => env('DISCOGS_KEY'),
                    'secret' => env('DISCOGS_SECRET')
                ]
            ]);
        }

        $response_body = (array) json_decode($response->getBody());
        $items = $this->recordTransformer->transformCollection($response_body['releases']);

        if (isset($response_body['pagination']->urls->next)) {
            $next_parse_url = parse_url($response_body['pagination']->urls->next);
            $next_parse = parse_str($next_parse_url['query'], $next);
        } else {
            $next = false;
        }

        if (isset($response_body['pagination']->urls->prev)) {
            $prev_parse_url = parse_url($response_body['pagination']->urls->prev);
            parse_str($prev_parse_url['query'], $prev);
        } else {
            $prev = false;
        }

        return $this->respond([
            'paginator' => [
                'total_count' => $response_body['pagination']->items,
                'total_pages' => $response_body['pagination']->pages,
                'current_page' => $response_body['pagination']->page,
                'limit' => $response_body['pagination']->per_page,
                'next_page' => $next['page'] ? 'https://api.itsluk.dev/records?page=' . $next['page'] : null,
                'prev_page' => $prev['page'] ? 'https://api.itsluk.dev/records?page=' . $prev['page'] : null,
            ],
            'data' => $items,
        ]);
    }

    /**
     * get single release
     * @param Request $request
     * @param int $release
     * @return mixed
     */
    public function getRelease(Request $request, $release)
    {
        if (!$release) {
            $this->respondWithValidationError('Sorry, could not find release identifier.');
        }

        $response = $this->client()->request('GET', 'https://api.discogs.com/releases/' . $release, [
            'query' => [
                'key' => env('DISCOGS_KEY'),
                'secret' => env('DISCOGS_SECRET')
            ]
        ]);

        $response_body = (array) json_decode($response->getBody());

        $item = $this->recordTransformer->transformRelease($response_body);

        return $this->respond([
            'data' => $item,
        ]);
    }
}
