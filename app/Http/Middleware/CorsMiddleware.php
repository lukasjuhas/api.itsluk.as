<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'HEAD, GET, POST, PUT, PATCH, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers')
        ];

        if ($request->isMethod('OPTIONS')) {
            $response->setStatusCode(200);
            $response->setContent('OK');
        }

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
