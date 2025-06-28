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
    private string $driverGoogle = 'google';


    public function loginForm()
    {
        if (\Auth::check() && !\Auth::user()->isAdmin()) {
            return redirect(route('home'));
        }
        return view('Frontend.page.Auth.login');
    }


    public function login(Request $request)
    {

        $this->validateRequest([
            'email' => 'required|email|string_vertify',
            'password' => 'required|string_vertify'
        ], $request, User::getAttributeName());
        $email = $request->input('email');
        $password = $request->input('password');


        $user = User::where('email', $email)->first(['id', 'email', 'status', 'username', 'role']);
        if ($user) {
            if ($user->status != 1) {
                return response()->json(['status' => StatusReponse::ERROR, 'message' => 'Tài khoản của bạn đã bị khóa']);
            }
            if (in_array($user->username, ['admin', 'superadmin'])) {
                return response()->json(['status' => StatusReponse::ERRO, 'message' => 'Tài khoản không hợp lệ']);
            }
            if (auth()->attempt(['email' => $email, 'password' => $password])) {
                $agent = new Agent();
                LoginHistory::setLoginHistoryNotUseShouldQueue($user, request()->ip());
                Visits::saveVisits($user->id, $agent, \Request::userAgent());
                UserActivities::createUserActivityDuration($user->id, session()->getId());
                $targetUrl = '';
                // lưu lần đầu đăng nhập
                if (is_null($user->last_login)) {
                    $user->last_login = \Carbon::now();
                    $user->save();
                }

                // trở lại url khi thao tác bị hết hạn 401
                if (session()->has('target_url')) {
                    $targetUrl = session()->get('target_url');
                    session()->forget('target_url');
                    return response()->json(['message' =>  trans('auth.success'), 'status' => 'success', 'redirect' => $targetUrl]);
                }

                return response()->json(['message' =>  trans('auth.success'), 'status' => 'success', 'redirect' => route('home')]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Email hoặc mật khẩu không đúng']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Email hoặc mật khẩu không đúng']);
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

        UserActivities::endUserActivityDuration($id, $sessionId);
        return redirect(route('home'));
    }

    //callback google
    public function callbackGoogle()
    {
        $data = [
            'url_google' => Socialite::driver($this->driverGoogle)->redirect()->getTargetUrl(),
        ];
        return $this->sendApiResponse($data, 'Get driver login success');
    }

    public function handleLoginCallbackGoogle()
    {
        try {
            $google_user = Socialite::driver($this->driverGoogle)->user();
            $user = User::where('google_id', $google_user->id)->first();
            if (!$user) {
                $user = User::create(
                    [
                        'email' => $google_user->email,
                        'username' => 'Google_' . $google_user->id,
                        'firstname' => $google_user->user['family_name'],
                        'lastname' => $google_user->user['given_name'],
                        'avatar' => $google_user->avatar,
                        'google_id' => $google_user->id,
                        'password' => \Hash::make('123456'),
                    ]
                );
            }


            // $agent = new Agent();
            // LoginHistory::setLoginHistoryNotUseShouldQueue($user, request()->ip());
            // Visits::saveVisits($user->id, $agent, \Request::userAgent());
            // UserActivities::createUserActivityDuration($user->id, session()->getId());
            $data = [
                'token' => $user->createToken('accessToken', ['*'], \Carbon\Carbon::now()->addDays(7))->plainTextToken,
                'refreshToken' => $user->createToken('refreshToken', ['*'], \Carbon\Carbon::now()->addMonths())->plainTextToken,
                'status' => true,
                'email' => $user->email
            ];
            return $this->sendApiResponse($data, 'Login succesfully');
        } catch (\Exception $exception) {
            \Log::error('Google Login Error: ' . $exception->getMessage());
            return redirect()->route('home');
        }
    }
}
