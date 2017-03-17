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
     * authenticate user
     *
     * @return mmixed
     */
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = $this->jwt->parseToken()->authenticate()) {
                return $this->respondNotFound('User not found.');
            }
        } catch (TokenExpiredException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (TokenInvalidException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (JWTException $e) {
            return $this->respondWithError($e->getMessage());
        }

        // the token is valid and we have found the user via the sub claim
        return $this->respondWithSuccess('Successfully authenticated.');
    }
}
