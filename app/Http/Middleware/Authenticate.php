<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {

        if (!Auth::guard($guard)->check()) {
            if ($request->ajax() || $request->bearerToken()) {
                if (!session()->has('target_url')) {
                    $refererUrl = $request->header('Referer');
                    session()->put('target_url', $refererUrl);
                }

                return response()->json(["message" => "Authentication failed!"], 401);
            }
            if (!session()->has('target_url')) {
                session()->put('target_url', $request->fullUrl());
            }
            if ((request()->segment(1) == 'private' && request()->segment(2) == 'system') || request()->segment(1) == 'log-viewer')
                return redirect(route('private-system.be.login.template'));

            else
                abort(404);
        }


        if (Auth::guard($guard)->check()) {
            $userId = Auth::guard($guard)->id();
            if (!cache('avatar_' . $userId)) {
                $avatar = User::whereId($userId)->value('avatar');
                Cache::forever('avatar_' . $userId, $avatar ?? '');
            }
            Auth::setUser(Auth::guard($guard)->user());
        }
        return $next($request);
    }
}
