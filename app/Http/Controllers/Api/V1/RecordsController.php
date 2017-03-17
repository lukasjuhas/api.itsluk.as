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

    public function index(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.discogs.com',
            'headers' => [
                'User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as',
                'Content-Type' => 'application/json',
            ]
        ]);

        if ($request->get('page')) {
            $response = $client->request('GET', 'users/itslukas/collection', [
                'query' => [
                    'page' => $request->get('page'),
                    'per_page' => 25,
                    'key' => env('DISCOGS_KEY'),
                    'secret' => env('DISCOGS_SECRET')
                ]
            ]);
        } else {
            $response = $client->request('GET', 'users/itslukas/collection', [
                'query' => [
                    'per_page' => 25,
                    'key' => env('DISCOGS_KEY'),
                    'secret' => env('DISCOGS_SECRET')
                ]
            ]);
        }

        $response_body = (array) json_decode($response->getBody());
        $items = $this->recordTransformer->transformCollection($response_body['releases']);

        // add large thumb;
        // foreach($items as $key => $item) {
        //     $release_id = $item['release_id'];
        //
        //     $request_release = $client->request('GET', 'https://api.discogs.com/releases/' . $release_id, [
        //       'query' => ['key' => env('DISCOGS_KEY'), 'secret' => env('DISCOGS_SECRET')]
        //     ]);
        //
        //     $request_release_body = (array) json_decode($request_release->getBody());
        //     $items[$key]['thumb_large'] = $request_release_body['images'][0]->uri;
        // }

        // dd($response_body['pagination']);
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
}
