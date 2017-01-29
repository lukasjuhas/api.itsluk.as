<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response as IlluminateResponse;
use App\User;

class ApiController extends BaseController
{
    /**
     * @var integer
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param   mixed    $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param Paginator $items
     * @param $data
     * @return mixed
     */
    public function respondWithPagination($items, $data)
    {
        $data = array_merge([
          'paginator' => [
              'total_count' => $items->total(),
              'total_pages' => ceil($items->total() / $items->perPage()),
              'curent_page' => $items->currentPage(),
              'limit' => (int) $items->perPage()
          ]
        ], $data);

        return $this->respond($data);
    }

    public function respondCreated($id, $message = 'Successfully created.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
            'id' => $id,
            'message' => $message
        ]);
    }

    public function respondWithValidationError($message = 'Parameters failed validation.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }


    public function getRequestingUser($request)
    {
        $user = false;

        if($request->method() == 'POST') {
            if(!$request->has('token')) {
                $user = false;
            }

            $user = User::where('api_token', $request->get('token'))->first();

            if(!$user) {
                $user = false;
            }
        }

        return $user;
    }
}
