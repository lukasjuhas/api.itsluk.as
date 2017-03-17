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

    protected $baseApiUri = 'https://api.discogs.com';

    public function __construct(RecordTransformer $recordTransformer)
    {
        $this->recordTransformer = $recordTransformer;
    }

    /**
     * set client
     *
     * @return GuzzleHttp\Client
     */
    private function client()
    {
        return new Client([
            'base_uri' => $this->baseApiUri,
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
     * 
     * @param Request $request
     * @param int $release
     * @return mixed
     */
    public function getRelease(Request $request, $release)
    {
        if (!$release) {
            $this->respondWithValidationError('Sorry, could not find release identifier.');
        }

        $response = $this->client()->request('GET', 'https://api.discogs.com/releases/' . $release);

        $item = $this->recordTransformer->transformRelease($this->prase_reponse($response));

        return $this->respond([
            'data' => $item,
        ]);
    }
}
