<?php 

namespace App\Http\Middleware;

// CORS for developing
class CorsMiddleware {

    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        $response->header('Access-Control-Allow-Origin', env('ACCESS_CONTROLL_ALLOW_ORIGIN'));

        return $response;
    }
}