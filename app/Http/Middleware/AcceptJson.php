<?php

namespace App\Http\Middleware;

use Closure;

class AcceptJson
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
        if ($request->format() != 'json') {
            return response()->json([
                    'message' => 'Accept header not valid',
                ], 415); 
        } 

        return $next($request);
    }
}
