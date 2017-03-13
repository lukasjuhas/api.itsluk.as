<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return $this->respondWithError('User not found.');
            }
        } catch (TokenExpiredException $e) {
            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token Expired.');
        } catch (TokenInvalidException $e) {
            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token invalid.');
        } catch (JWTException $e) {
            return $this->setStatusCode($e->getStatusCode())->respondWithError('Token absent.');
        }

        return $this->respond(compact('token'));
    }
}
