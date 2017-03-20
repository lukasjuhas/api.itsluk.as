<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\User;

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

    /**
     * login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required'
        ]);

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return $this->respondWithError('User not found.');
            }
        } catch (TokenExpiredException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (TokenInvalidException $e) {
            return $this->respondWithUnauthorised($e->getMessage());
        } catch (JWTException $e) {
            return $this->respondWithError($e->getMessage());
        }

        return $this->respond(compact('token'));
    }

    /**
     * logout
     *
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        $logout = $this->jwt->invalidate($this->jwt->parseToken());

        if ($logout) {
            return $this->respondWithSuccess('Succesfully Logged out.');
        }

        return $this->respondWithError('There was problem logging you out.');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->only('email'))->first();

        if ($user) {
            Mail::raw('Raw string email', function($msg) use ($user) {
              $msg->to([$user->email]);
              $msg->from(['noreply@itsluk.as']);
            });
        }

    }
}
