<?php

namespace App\Http\Middleware;

use Closure;
use Modules\User\Entities\ProfileChangedPass;
use Spatie\Permission\Exceptions\UnauthorizedException;
use TorMorten\Eventy\Facades\Events;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Session;

class AuthorizeAdmin 
{
    public function handle(Request $request, Closure $next)
    {

        if (\Auth::check() && \Auth::user()->isAdmin()) {
            return $next($request);
        }
        abort(403);
//        return redirect('/');
    }
}

