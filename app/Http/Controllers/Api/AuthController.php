<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainUserAddress;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function getCurrentUser()
    {
        $user = auth()->user();
        $user->load('usersAddress');
        return $this->sendApiResponse($user, null);
    }

    public function saveAddress(Request $request)
    {
        $data = $request->all();
        $validated = Validator::make($data, [
            'province_code' => 'required|integer|exists:provinces,code',
            'ward_code' => 'required|integer|exists:wards,code',
            'address' => 'required|string',
            'receiver_name' => "required|string|max:100",
            'default' => 'nullable'
        ]);
        if ($validated->fails()) {
            return $this->sendApiResponse(['errors' => $validated->errors()->first()], 'Invalid request', 422);
        }

        $id = $request->input('id');
        if ($id) {
            $mainAddress = MainUserAddress::findOrFail($id);
            $mainAddress->update($data);
        } else {
            $mainAddress = MainUserAddress::create($data);
        }

        if ($mainAddress) {
            if (isset($data['default']) && !empty($data['default'])) {
                MainUserAddress::where('id', '!=', $mainAddress->id)->whereUserId(auth()->id())->update([
                    'default' => 0
                ]);
            }
            return $this->sendApiResponse(message: 'Lưu địa chỉ thành công');
        }
        return $this->sendApiResponse(message: 'Failed to save address', status: 419);
    }

    public function getAddressCurrent($id)
    {
        $address = MainUserAddress::where('user_id', auth()->id())->find($id);
        return $this->sendApiResponse($address, 'success');
    }


    public function getAddressCode(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'code' => 'nullable|integer|exists:provinces,code',
        ]);
        if ($validated->fails()) {
            return $this->sendApiResponse(['errors' => $validated->errors()->first()], 'Invalid request', 422);
        }
        $message = '';
        if ($request->has('code') && !empty($request->code)) {
            $code = $request->code;
            $data = \Cache::rememberForever('district_code_' . $code, function () use ($code) {
                return Ward::where('provinceCode', $code)->select(['code as value', 'fullName as label'])->get();
            });
            $message = 'Get wards success by ' . $code;
        } else {
            $data = \Cache::remember('province_code', \Carbon\Carbon::now()->addMonth(), function () {
                return Province::whereNotNull('code')->select(['code as value', 'fullName as label'])->get();
            });
            $message = 'Get all provinces success';
        }
        return $this->sendApiResponse($data, $message);
    }

    public function getCodeDetailAddress(MainUserAddress $address)
    {
        return $this->sendApiResponse($address, 'success');
    }

    public function removeAddress(MainUserAddress $address)
    {
        $address->delete();
        return $this->sendApiResponse(message: __('Delete address successfully.'));
    }

    public function saveUserInfo(Request $request)
    {
        $data = $request->all();
        $validated = Validator::make($data, [
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address_default' => "nullable|integer|exists:main_users_address,id",
        ]);


        if ($validated->fails()) {
            return $this->sendApiResponse(['errors' => $validated->errors()->first()], 'Invalid request', 422);
        }
        $splitData = explode(' ', $data['full_name']);
        $user = auth()->user();
        $user->firstname = $splitData[0];
        $user->lastname = $splitData[1];
        $user->fill($data);
        $user->save();
        if (isset($data['address_default']) && !empty($data['address_default'])) {
            MainUserAddress::where('user_id', $user->id)
                ->update(['default' => 0]);
            MainUserAddress::where('id', $data['address_default'])->where('user_id', $user->id)
                ->update(['default' => 1]);
        }

        return $this->sendApiResponse(message: __('Update user info successfully.fac'));
    }
}
