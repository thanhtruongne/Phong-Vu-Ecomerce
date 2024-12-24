<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use App\Enums\Enum\StatusReponse;
use App\Models\User;
use App\Models\LoginHistory;
use App\Models\Visits;
use App\Models\UserActivities;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
{
    public function loginForm(){
       if(\Auth::check() && !\Auth::user()->isAdmin()){
            return redirect(route('home'));
       }
       return view('Frontend.page.Auth.login');
    }


    public function login(Request $request)
    {

       $this->validateRequest([
        'email' => 'required|email|string_vertify',
        'password' => 'required|string_vertify'
       ],$request,User::getAttributeName());
       $email = $request->input('email');
       $password = $request->input('password');

       $user = User::where('email',$email)->first(['id','email','status','username','role']);
       if($user){
            if($user->status != 1){
                return response()->json(['status' => StatusReponse::ERROR,'message' => 'Tài khoản của bạn đã bị khóa']);
            }
            if(in_array($user->username,['admin','superadmin'])){
                return response()->json(['status' => StatusReponse::ERRO,'message' => 'Tài khoản không hợp lệ']);
            }
            if(auth()->attempt(['email' => $email , 'password' => $password])){
                $agent = new Agent();
                LoginHistory::setLoginHistoryNotUseShouldQueue($user,request()->ip());
                Visits::saveVisits($user->id,$agent,\Request::userAgent());
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

                return response()->json(['message' =>  trans('auth.success'), 'status' => 'success','redirect' => route('home')]);
            } else {
                return response()->json(['status' => 'error','message' => 'Email hoặc mật khẩu không đúng']);
            }
        } else {
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
        return redirect(route('home'));

    }

    //callback google
    public function callBackGoogle()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                ->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(),'status' => StatusReponse::ERROR]);
        }
    }

    public function handleLoginCallbackGoogle(Request $request)
    {
        try {
            $state = $request->input('state');
            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->email)->first();
            if (!$user) {
                $user = User::create(
                    [
                        'email' => $googleUser->email,
                        'username' => 'Google_'.$googleUser->id,
                        'firstname' => $googleUser->user['family_name'],
                        'lastname' => $googleUser->user['given_name'],
                        'avatar' => $googleUser->avatar,
                        'google_id'=> $googleUser->id,
                        'password'=> \Hash::make('123456'),
                    ]
                );
            }
            if($user->status != $this->status_user_check) {
                return redirect(route('login'));
            }

            if(auth()->login($user,true)){
                $agent = new Agent();
                LoginHistory::setLoginHistoryNotUseShouldQueue($user,request()->ip());
                Visits::saveVisits($user->id,$agent,\Request::userAgent());
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
                    return redirect($targetUrl);
                }
                return redirect()->to('/');

            }
        } catch (\Exception $exception) {
            return redirect(route('login'));
        }
    }
}
