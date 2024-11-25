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
        $this->validateRequest([
            'username' => 'required|string_vertify',
            'password' => 'required|string|string_vertify'
        ],$request,User::getAttributeName());
        $username = $request->input('username');
        $password = $request->input('password');
        $user = User::whereUsername($username)->first(['id','username','role','password','email','status']);

        if($user){
           if($user->status != 1){
                return response()->json(['status' => 'error','message' => 'Tài khoản của bạn đã bị khóa']);
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
                
                return response()->json(['message' =>  trans('auth.success'), 'status' => 'success','redirect' => route('private-system.dashboard')]);
            } else {
                return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng']);
            }
        }
        else {
            return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng']);
        } 
    }
    public function logout(Request $request)
    {
        $id = auth()->id();
        $model = LoginHistory::where('user_id', '=', $id)->orderBy('created_at', 'DESC')->first();
        if ($model) {
            $model->updated_at = time();
            $model->save();
        }
        $sessionId = session()->getId();
        session()->flush();
        auth()->logout();
        $request->session()->invalidate();

        UserActivities::endUserActivityDuration($id,$sessionId);
        return  redirect(route('private-system.be.login.template'));
    }
}
