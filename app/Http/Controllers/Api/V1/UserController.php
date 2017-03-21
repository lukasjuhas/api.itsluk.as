<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class UserController extends ApiController
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    /**
     * constructor
     *
     * @param JWTAuth $jwt
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * authenticate
     *
     * @return mmixed
     */
    public function authenticate()
    {
        $authenticated = $this->getAuthenticatedUser();

        if ($authenticated) {
            return $this->respondWithSuccess('Successfully authenticated.');
        }

        return $this->respondWithError('There was problem authenticating user.');
    }

    /**
     * get authenticated user
     * @return mixed
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = $this->jwt->parseToken()->authenticate()) {
                return $this->respondNotFound('User not found.');
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return $this->respondWithError($e->getMessage());
        }

        return $this->respond([
            'message' => 'Succesfully Authneticated',
            'data' => compact('user'),
        ]);
    }
}
