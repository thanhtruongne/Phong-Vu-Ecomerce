<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
class CkFinderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        config(['ckfinder.authentication' => function() use ($request) {
            // dd(auth()->user());
            dd(auth()->guard('web')->user());
            return true;
        }] );

        return $next($request);
    }
}