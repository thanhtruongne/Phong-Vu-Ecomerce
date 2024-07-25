<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session as FacadesSession;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$guards ): Response
    {  

        if(PersonalAccessToken::findToken($request->bearerToken()) &&
         !PersonalAccessToken::findToken($request->bearerToken())->expires_at->gt(now())){
            $request->user('admin')->tokens()->delete();
            auth()->guard('admin')->logout();
            Cookie::queue(Cookie::forget('token'));
            return redirect()->route('private-system.login')->with('warning','Vui lòng đăng nhập lại');
        }                                                                    
        // dd(request()->user()->currentAccessToken()->token);
        // dd($request->bearerToken());
        
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard)
        {
            if (Auth::guard($guard)->check())
            {
                return $next($request);
            }
        }
        abort(403, 'Unauthenticated');
    }
}
