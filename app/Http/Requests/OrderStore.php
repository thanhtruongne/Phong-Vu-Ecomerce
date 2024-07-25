<?php

namespace App\Http\Requests;

use App\Rules\CustomValidateEmail;
use App\Rules\CustomValidateFullName;
use App\Rules\CustomValidatePhone;
use App\Rules\customValitePriceMethod;
use Illuminate\Foundation\Http\FormRequest;

class OrderStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required',new CustomValidateFullName()],
            'email' => ['required','email',new CustomValidateEmail()],
            'phone' => ['required',new CustomValidatePhone()],
            'province_code' => ['required'],
            'district_code' => ['required'],
            'ward_code' => ['required'],
            'address' =>['required'],
            'method' => ['required'],
            'total' => [new customValitePriceMethod($this->input('method'))]

        ];
    }

    public function messages() {
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'email.required' => 'Mục email không được bỏ trống',
            'email.email' => 'Mục email không đúng định dạng',
            'phone.required' => 'Mục sdt không được bỏ trống',
            'province_code.required' => 'Mục Tỉnh/Thành phố không được bỏ trống',
            'district_code.required' => 'Mục Quận/Huyện không được bỏ trống',
            'ward_code.required' => 'Mục Phường/Xã không được bỏ trống',
            'address.required' =>'Mục địa chỉ không được bỏ trống',
            'method.required' => 'Phương thức thanh toán không được bỏ trống'
        ];
    }
}
