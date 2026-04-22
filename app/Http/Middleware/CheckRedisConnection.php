<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redis;

class CheckRedisConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            Redis::connection()->ping();
        } catch (\Exception $e) {
            return response()->view('errors.500', [], 500);
        }
        return $next($request);
    }
}
