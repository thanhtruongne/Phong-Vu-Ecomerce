<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\BaseController;
use App\Http\Requests\Frontend\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends BaseController
{
    public function login(){
        // if(Auth::guard('web')->check()) return abort(403);
        $Seo = $this->Seo;
        return view('Frontend.page.Auth.login',compact('Seo'));
    }


    public function StoreLogin(LoginRequest $request){
      
        $credentials = request(['email','password']);
        if(!Auth::guard('web')->attempt($credentials)){
           
            return redirect()->route('login')->with('error','Email hoặc mật khẩu không hợp lệ');  
        }
       
        $user = $request->user('web');
        $token = $user->createToken('token',['*'],now()->addMinutes(240000))->plainTextToken;
        return redirect()->route('home')->withCookie('token',$token,null);  
        
    }

    public function logout(Request $request)
    {
        $accessToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();
        Cookie::queue(Cookie::forget('token'));
        Auth::guard('web')->logout();
        return redirect()->route('home');
    }
}