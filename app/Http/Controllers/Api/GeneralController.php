<?php

namespace App\Http\Controllers\Api;

use App\Enums\SocialteDriver;
use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\Slider;
use App\Models\User;
use App\Models\UserActivities;
use App\Models\Visits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Laravel\Socialite\Facades\Socialite;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Brand;
use Modules\Products\Entities\Products;
use Modules\Widget\Entities\Widget;



class GeneralController extends Controller
{


    public function getDataLayout(Request $request)
    {

        // $widgets = Widget::whereNotNull('name')->where('status', 1)->get();
        // $data_widget = $this->getWidgetData($widgets);
        $slider = \Cache::tags(['slider', 'brand'])->remember('sliders', \Carbon::now()->addDays(2), function () {
            return Slider::whereKeyword('slider-home')->whereNotNull('content')->first();
        });

        $productCategory = \Cache::remember('categories', \Carbon\Carbon::now()->addDays(7), function () {
            return ProductCategory::get(['id', 'name', '_lft', '_rgt', 'parent_id', 'url', 'icon'])->toTree();
        });

        $data = [
            'slider' => $slider->item,
            'dataCategories' => $productCategory
        ];
        return $this->sendApiResponse($data, 'Get data layout success');
    }

    public function callBackGoogle(Request $request)
    {
        try {
            $data = [
                'url_google' => Socialite::driver(SocialteDriver::GOOGLE)->stateless()->redirect()->getTargetUrl(),
            ];
            return $this->sendApiResponse($data, 'Get driver login success');
        } catch (\Throwable $th) {
            return $this->sendApiResponse($th->getMessage(), 'Get driver login error');
        }
    }


    public function handleLoginCallbackGoogle()
    {
        try {
            $google_user = Socialite::driver(SocialteDriver::GOOGLE)->stateless()->user();
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


            $agent = new Agent();
            LoginHistory::setLoginHistoryNotUseShouldQueue($user, request()->ip());
            Visits::saveVisits($user->id, $agent, \Request::userAgent());
            $data = [
                'token' => $user->createToken('accessToken', ['*'], \Carbon\Carbon::now()->addDays(7))->plainTextToken,
                'refreshToken' => $user->createToken('refreshToken', ['*'], \Carbon\Carbon::now()->addMonths())->plainTextToken,
                'status' => true,
                'email' => $user->email
            ];
            return $this->sendApiResponse($data, 'Login succesfully');
        } catch (\Throwable $th) {
            // Log::info('Google log info : ', [$th->getMessage()]);
            return $this->sendApiResponse($th->getMessage(), 'Login error');
        }
    }
}
