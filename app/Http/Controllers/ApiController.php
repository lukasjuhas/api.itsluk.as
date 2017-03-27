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

    /**
     * respond not found
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * respond internal server error
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * respond
     * @param Array $data
     * @param Array $headers
     * @return mixed
     */
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
                'limit' => (int) $items->perPage(),
                'next_page' => $items->nextPageUrl(),
                'prev_page' => $items->previousPageUrl()
            ]
        ], $data);

        return $this->respond($data);
    }

    /**
     * respond created
     * @param int $id
     * @param string $message
     * @return mixed
     */
    public function respondCreated($message = 'Successfully created.', $data = false)
    {
        if ($data) {
            $response = [
              'data' => $data,
              'message' => $message
          ];
        } else {
            $response = [
              'message' => $message
          ];
        }

        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond($response);
    }

    /**
     * respond updated
     * @param int $id
     * @param string $message
     * @return mixed
     */
    public function respondUpdated($message = 'Successfully updated.', $id = false)
    {
        if ($id) {
            $response = [
              'id' => $id,
              'message' => $message
          ];
        } else {
            $response = [
              'message' => $message
          ];
        }

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respond($response);
    }

    /**
     * respond validation error
     * @param string $message
     * @return mixed
     */
    public function respondWithValidationError($message = 'Parameters failed validation.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * respond with error
     * @param String $message
     * @return mixed
     */
    public function respondWithError($message = 'There was an error.')
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * respond with success
     * @param String $message
     * @return mixed
     */
    public function respondWithSuccess($message = 'Success!', $data = false)
    {
        if ($data) {
            $response = [
                'data' => $data,
                'message' => $message
            ];
        } else {
            $response = [
                'message' => $message
            ];
        }

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respond($response);
    }

    /**
     * get requesting user
     * @param Request $request
     * @return mixed
     */
    public function getRequestingUser($request)
    {
        $user = false;

        if ($request->method() == 'POST') {
            if (!$request->has('token')) {
                $user = false;
            }

            $user = User::where('api_token', $request->get('token'))->first();

            if (!$user) {
                $user = false;
            }
        }

        return $user;
    }

    /**
     * unauthorised
     * @param string $message
     * @return mixed
     */
    public function respondWithUnauthorised($message = 'Unauthorised')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }
}
