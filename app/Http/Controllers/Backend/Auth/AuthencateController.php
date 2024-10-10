<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Authencate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthencateController extends Controller
{
    protected $userRepositories;

    public function __construct()
    {
    }

    public function index(Request $request){
       
       if(auth('admin')->check()) return abort(403);
        return view('backend.auth.login');
    }

    public function login(Request $request) {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
        $messages = [
            'password.required' => trans('auth.password_not_blank'),
            'email.required' => trans('auth.username_not_blank'),
            'email.email' => trans('auth.email_not_valid'),
        ];


        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0] , 'status' => 'error']);
        }

        $email = $request->input('email');
        $password = $request->input('password');
        $remember =  $request->input('remember');
        


        $user = User::whereEmail($email)->first(['id','username','role','password','email','status']);

        if($user){
           if($user->status != 1){
                return response()->json(['status' => 'error','message' => 'Tài khoản của bạn đã bị khóa']);
           }

           if($user->login(['email' => $email , 'password' => $password],$remember)){
            
           }
        }
        else {
            return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng']);
        }

        // if(!Auth::guard('admin')->attempt($credentials)){
        //     return redirect()->route('private-system.login')->with('error','Email hoặc mật khẩu không hợp lệ');  
        // }
        
        // $user = $request->user('admin');
        // $token = $user->createToken('token',['*'],now()->addMinutes(180))->plainTextToken;
        // return redirect()->route('private-system.dashboard')->withCookie('token',$token,null);
        // ->withCookie('token',$token,null);  
    }
    public function logout(Request $request) {
         $request->user('admin')->tokens()->delete();
        
         Auth::guard('admin')->logout();
         Cookie::queue(Cookie::forget('token'));
        return redirect()->route('private-system.login');
        
    }
}
