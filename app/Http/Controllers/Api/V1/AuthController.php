<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
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

    /**
     * reset password
     * @param Request $request
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->only('email'))->first();


        if ($user) {
            $randomString = md5(uniqid($user->email, true));

            $url = env('SITE_URL', 'itsluk.as');
            $fullUrl = $url . '/reset-password?email=' . $user->email . '&token=' . $randomString;

            $message = 'Reset your password ' . $fullUrl;

            DB::table('password_resets')->where('email', $user->email)->update([
                'token' => app('hash')->make($randomString),
            ]);

            Mail::raw($message, function ($msg) use ($user) {
                $msg->to([$user->email]);
                $msg->from(['noreply@itsluk.as']);
            });
        }
    }

    /**
     * validate reset password
     * @param Request $request
     */
    public function validateResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = User::where('id', 1)->first();
        $resetToken = DB::table('password_resets')->select('token')->where('email', $user->email)->first();

        if (!$user || !$resetToken) {
            return $this->respondWithError('There are no records of this user matching these credentials.');
        }

        if (app('hash')->check($request->get('token'), $resetToken->token)) {
            return $this->respondWithSuccess('Succesfully validated token.');
        } else {
            return $this->respondWithError('Validation failed.');
        }
    }

    /**
     * New password
     * @param Request $request
     * @return mixed
     */
    public function newPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password'   => 'required|min:6',
            'repassword' => 'same:password',
        ]);

        $user = User::where('email', $request->get('email'))->first();

        if (!$user) {
            return $this->respondWithError('There are no records of this user matching these credentials.');
        }

        $update = $user->update([
            'password' => app('hash')->make($request->get('password'))
        ]);

        if ($update) {
            $this->clearResetPasswordToken($user);

            return $this->respondWithSuccess('Succesfully updated password.');
        }
    }

    /**
     * remove token after succesfull password change
     * @param App\User $user
     */
    private function clearResetPasswordToken($user)
    {
        if ($user) {
            return DB::table('password_resets')->where('email', $user->email)->first()->delete();
        }
    }
}
