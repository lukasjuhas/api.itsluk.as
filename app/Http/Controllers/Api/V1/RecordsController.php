<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;

use Transformers\RecordTransformer;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

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

    public function index()
    {
        // $token = false;
        //
        // if(!$token) {
        //     $stack = HandlerStack::create();
        //     $middleware = new Oauth1([
        //       'consumer_key'    => 'htWoPCOmPLRCwirWZkdv',
        //       'consumer_secret' => 'sgnQdLGkvjKcTAlXhsXebkpTsDXmuaQk',
        //       'token' => '',
        //       'token_secret' => ''
        //     ]);
        //
        //     $stack->push($middleware);
        //
        //     $client = new Client([
        //         'base_uri' => 'https://api.discogs.com',
        //         'handler' => $stack,
        //         'headers' => [
        //             'User-Agent' => 'api.itsluk.dev/1.0.0 +http://api.itsluk.dev',
        //             'Content-Type' => 'application/json',
        //         ]
        //     ]);
        //
        //     $response = $client->request('GET', 'oauth/request_token', ['auth' => 'oauth']);
        //     print_r($response); die();
        // }

        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => 'htWoPCOmPLRCwirWZkdv',
            'consumer_secret' => 'sgnQdLGkvjKcTAlXhsXebkpTsDXmuaQk',
            'token'           => '',
            'token_secret'    => ''
        ]);

        $stack->push($middleware);

        $config = [
            'defaults' => [
                'headers' => ['User-Agent' => 'api.itsluk.dev/1.0.0 +http://api.itsluk.dev'],
            ],
        ];

        $service = [
            'baseUrl' => 'https://api.discogs.com/',
            'operations' => [
                'getCollection' => [
                    'httpMethod' => 'GET',
                    'uri' => 'users/{username}/collection',
                    'parameters' => [
                        'username' => [
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true
                        ]
                    ]
                ],
            ]
        ];

        $client = new Client([
            'base_uri' => 'https://api.discogs.com',
            'handler' => $stack,
            'headers' => [
                'User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as',
                'Content-Type' => 'application/json',
            ]
        ]);

        $response = $client->request('GET', 'users/itslukas/collection?per_page=25', ['auth' => 'oauth']);
        $response_body = (array) json_decode($response->getBody());
        $items = $this->recordTransformer->transformCollection($response_body['releases']);

        return $this->respond([
            'paginator' => [
                'total_count' => $response_body['pagination']->items,
                'current_page' => $response_body['pagination']->page,
                'total_pages' => $response_body['pagination']->pages,
                'limit' => $response_body['pagination']->per_page
            ],
            'data' => $items,
        ]);
    }

    public function page($page_number)
    {
        $config = [
            'defaults' => [
                'headers' => ['User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as'],
            ],
        ];

        $service = [
            'baseUrl' => 'https://api.discogs.com/',
            'operations' => [
                'getCollection' => [
                    'httpMethod' => 'GET',
                    'uri' => 'users/{username}/collection',
                    'parameters' => [
                        'username' => [
                            'type' => 'string',
                            'location' => 'uri',
                            'required' => true
                        ]
                    ]
                ],
            ]
        ];

        $client = new Client([
            'base_uri' => 'https://api.discogs.com',
            'headers' => [
                'User-Agent' => 'api.itsluk.as/1.0.0 +http://api.itsluk.as',
                'Content-Type' => 'application/json',
            ]
        ]);

        $response = $client->request('GET', 'users/itslukas/collection?page=' . $page_number);
        $response_body = (array) json_decode($response->getBody());
        $items = $this->recordTransformer->transformCollection($response_body['releases']);

        return $this->respond([
            'paginator' => [
                'total_count' => $response_body['pagination']->items,
                'current_page' => $response_body['pagination']->page,
                'total_pages' => $response_body['pagination']->pages,
                'limit' => $response_body['pagination']->per_page
            ],
            'data' => $items,
        ]);
    }
}
