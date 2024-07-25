<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Authencate;
use App\Repositories\UserRepositories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;

class AuthencateController extends Controller
{
    protected $userRepositories;

    public function __construct(UserRepositories $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function login(Request $request){
       
       if(auth('admin')->check()) return abort(403);
        return view('backend.auth.login');
    }

    public function AdminStoreLogin(Authencate $request) {
         $credentials = request(['email','password']);
        if(!Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('private-system.login')->with('error','Email hoặc mật khẩu không hợp lệ');  
        }
        
        $user = $request->user('admin');
        $token = $user->createToken('token',['*'],now()->addMinutes(180))->plainTextToken;
        return redirect()->route('private-system.dashboard')->withCookie('token',$token,null);
        // ->withCookie('token',$token,null);  
    }
    public function logout(Request $request) {
         $request->user('admin')->tokens()->delete();
        
         Auth::guard('admin')->logout();
         Cookie::queue(Cookie::forget('token'));
        return redirect()->route('private-system.login');
        
    }
}
