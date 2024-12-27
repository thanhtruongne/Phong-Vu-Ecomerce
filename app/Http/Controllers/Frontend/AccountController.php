<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use App\Models\MainUserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\CustomValidatePhone;
use App\Enums\Enum\StatusReponse;
use Illuminate\Contracts\Database\Eloquent\Builder;

interface InterfaceAccountController {
    public function account();
    public function detailOrder(string $code = '');
    public function saveAddressUserMain(Request $request);
    public function removeAddressMain(Request $request);
    public function formAddressMain(Request $request);
}

class AccountController extends Controller implements InterfaceAccountController
{

    private $temp_count_address = 10;

    private $attemp_address_default = 1;

    public function account() {
        $user = User::findOrFail(profile()->id);
        $user->load(['user_session_address' => function(Builder $query){
            $query->where('default', $this->attemp_address_default);
        }]);
        // $user->loadMissing(['user_session_address']);
        return view('Frontend.page.Accounts.index',compact('user'));
    }
    public function accountOrder() {

        return view('Frontend.page.Accounts.orders.order');
    }

    public function detailOrder(string $code = '') {

        return view('Frontend.page.Accounts.orders.detail',compact('Seo','config','order'));
    }

    public function accountAddress(){
        $user = User::findOrFail(profile()->id);
        $user->load(['user_session_address' => function(Builder $query) {
            $query->orderBy('default','DESC');
            $query->select(['address','province_code','default','district_code','ward_code','receiver_phone','receiver_name','user_id','id'])->with(['province','ward','district']);
        }]);

        return view('Frontend.page.Accounts.addressMain',compact('user'));
    }


    public function saveAddressUserMain(Request $request){
         $this->validateRequest([
            // 'user_id' => 'required',
            'receiver_name' => 'required|string_vertify',
            'receiver_email' => 'required|email|string_vertify',
            'receiver_phone' => ['required','numeric',new CustomValidatePhone],
            'province_code' => 'required',
            'district_code' => 'required',
            'ward_code' => 'required',
            'address' => 'required',
         ],$request,MainUserAddress::getAttributeName());

        \DB::beginTransaction();
        try {
            $user = User::findOrFail(profile()->id);
            $user->loadMissing('user_session_address');

            if(isset($user->user_session_address) && !empty($user->user_session_address) && $user->user_session_address->count() >= $this->temp_count_address) {
                return response()->json(['message'=> trans('auth.address_attemp').$user->user_session_address->count(),'status' => StatusReponse::ERROR]);
            }
            if(isset($request->default) && !empty($request->default) && MainUserAddress::where('user_id',$user->id)->update([
                'default' => null
            ]));

            $model = MainUserAddress::firstOrNew(['id' => $request->id]);
            $model->fill($request->all());
            $model->with(['province','district','ward']);
            $model->user_id = $user->id;
            $model->default = $request->default;
            if($model->save()){
                \DB::commit();
                 return response()->json([
                    'message'=> 'Cập nhật thành công',
                    'status' => StatusReponse::SUCCESS,
                    'model' => !is_null($request->type) ? $user->user_session_address()->with(['province','ward','district'])->orderBy('default','DESC')->get() : $model,
                 ]);
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json(['message'=> $th->getMessage(),'status' => StatusReponse::ERROR,'line' =>$th->getLine()]);
        }
    }

    public function removeAddressMain(Request $request){
        $this->validateRequest([
            'id' => 'required',
            'user_id' => 'required'
        ],$request,MainUserAddress::getAttributeName());
        \DB::beginTransaction();
        try {
            $model = MainUserAddress::findOrFail($request->id);
            if($model->delete()){
                \DB::commit();
                 return response()->json([
                    'message'=> 'Xóa thành công',
                    'status' => StatusReponse::SUCCESS,
                    'model' => MainUserAddress::where('user_id',$request->user_id)->with(['province','ward','district'])->get()
                 ]);
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            return response()->json(['message'=> $th->getMessage(),'status' => StatusReponse::ERROR,'line' =>$th->getLine()]);
        }


    }

    public function formAddressMain(Request $request){
        $this->validateRequest([
            'id' => 'required',
        ],$request,MainUserAddress::getAttributeName());
        try {
            $model = MainUserAddress::with(['province','ward','district'])->findOrFail($request->id);
            return response()->json([
                'message'=> 'Transport thành công',
                'status' => StatusReponse::SUCCESS,
                'model' => $model
            ]);

        } catch (\Throwable $th) {
            return response()->json(['message'=> $th->getMessage(),'status' => StatusReponse::ERROR,'line' =>$th->getLine()]);
        }
    }
}
