<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class LogVisits
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $agent = new Agent();
            $users = \Cache::get('online-users');
            if(empty($users)) {
                \Cache::put('online-users', [['id' => Auth::user()->id, 'last_activity_at' => now(), 'ip_address' => request()->ip(), 'device' => $agent->device(), 'platform' => $agent->platform(), 'browser' => $agent->browser()]], \Config::get('session.lifetime'));
            } else {
                foreach ($users as $key => $user) {
                    if($user['id'] === Auth::user()->id) {
                        unset($users[$key]);
                        continue;
                    }
                    if ($user['last_activity_at'] < now()->subMinutes(10)) {
                        unset($users[$key]);
                        continue;
                    }
                }
                $users[] = ['id' => Auth::user()->id, 'last_activity_at' => now(), 'ip_address' => request()->ip(), 'device' => $agent->device(), 'platform' => $agent->platform(), 'browser' => $agent->browser()];
                \Cache::put('online-users', $users, \Config::get('session.lifetime'));
            }
        }
        return $next($request);
    }
}