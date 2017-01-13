<?php

namespace App\Http\Controllers;

use Transformers\VinylTransformer;
use GuzzleHttp\Client;

class VinylsController extends Controller
{
    /**
    * @var Transformers\VinylTransformer
    */
    protected $vinylTransformer;

    public function __construct(VinylTransformer $vinylTransformer)
    {
        $this->vinylTransformer = $vinylTransformer;
    }

    public function index()
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

        $response = $client->request('GET', 'users/itslukas/collection?per_page=25');
        $response_body = (array) json_decode($response->getBody());
        $items = $this->vinylTransformer->transformCollection($response_body['releases']);

        return $this->response()->array($items);
    }

    public function page($page_number) {
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
      $items = $this->vinylTransformer->transformCollection($response_body['releases']);

      return $this->response()->array($items);
    }
}
