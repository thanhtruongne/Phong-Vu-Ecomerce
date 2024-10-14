<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Authencate;
use App\Models\LoginHistory;
use App\Models\Visits;
use App\Models\UserActivities;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;

class AuthencateController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request){
       
        if(Auth::check())  {
            if(Auth::user()->isAdmin())
                return redirect()->back();
            
            else abort(404); 
        }

        return view('backends.pages.auth.login');
    } 

    public function login(Request $request) {
        $rules = [
            'username' => ['required'],
            'password' => ['required', 'string'],
        ];
        $messages = [
            'password.required' => trans('auth.password_not_blank'),
            'username.required' => trans('auth.username_not_blank'),
        ];


        $validator = \Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()[0] , 'status' => 'error']);
        }

        $username = $request->input('username');
        $password = $request->input('password');
        


        $user = User::whereUsername($username)->first(['id','username','role','password','email','status']);

        if($user){
           if($user->status != 1){
                return response()->json(['status' => 'error','message' => 'Tài khoản của bạn đã bị khóa','redirect' => route('private-system.be.login.template')]);
           }
           if(!in_array($user->username,['admin','superadmin'])){
                return response()->json(['status' => 'error','message' => 'Có lỗi xẩy ra','redirect' => route('private-system.be.login.template')]);
           }

           if(auth()->attempt(['username' => $username , 'password' => $password])){
            $request->session()->put('login_attempts', 0);
            $agent = new Agent();
            //lưu lịch sử đăng nhập
            LoginHistory::setLoginHistoryNotUseShouldQueue($user,request()->ip());
            //lưu thông tin đăng nhập
          
            Visits::saveVisits($user->id,$agent,\Request::userAgent());
            //lưu thời gian hoạt động
            UserActivities::createUserActivityDuration($user->id,session()->getId());
            $targetUrl ='';
            // lưu lần đầu đăng nhập
            if(is_null($user->last_login)){
                $user->last_login = \Carbon::now();
                $user->save();
            }
        
              // trở lại url khi thao tác bị hết hạn 401
            if (session()->has('target_url')) {
                $targetUrl = session()->get('target_url');
                session()->forget('target_url');
                return response()->json(['message' =>  trans('auth.success'), 'status' => 'success','redirect' => $targetUrl]);
            }
            // dd($targetUrl);
            return response()->json(['message' =>  trans('auth.success'), 'status' => 'success','redirect' => route('private-system.dashboard')]);
           }
           else {
            return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng','redirect' => route('private-system.be.login.template')]);
           }
        }
        else {
            return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng','redirect' => route('private-system.be.login.template')]);
        }

        // if(!Auth::guard('admin')->attempt($credentials)){
        //     return redirect()->route('private-system.login')->with('error','Email hoặc mật khẩu không hợp lệ');  
        // }
        
        // $user = $request->user('admin');
        // $token = $user->createToken('token',['*'],now()->addMinutes(180))->plainTextToken;
        // return redirect()->route('private-system.dashboard')->withCookie('token',$token,null);
        // ->withCookie('token',$token,null);  
    }
    public function logout(Request $request)
    {
        $model = LoginHistory::where('user_id', '=', \Auth::id())->orderBy('created_at', 'DESC')->first();
        if ($model) {
            $model->updated_at = time();
            $model->save();
        }
        $sessionId = session()->getId();
        session()->flush();
        $this->guard()->logout();
        $request->session()->invalidate();

        UserActivities::endUserActivityDuration(\Auth::id(),$sessionId);
        return  redirect(route('be.login.template'));
    }

    public function showLoginForm()
    {
        if (\auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login');
    }
}
