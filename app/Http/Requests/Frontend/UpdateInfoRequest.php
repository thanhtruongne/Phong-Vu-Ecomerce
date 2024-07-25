<?php

namespace App\Http\Requests\Frontend;

use App\Rules\CustomValidateEmail;
use App\Rules\CustomValidateFullName;
use App\Rules\CustomValidatePhone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInfoRequest extends FormRequest
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
            'email' => ['required',new CustomValidateEmail()],
            'name' => ['required'],
            'phone' => ['required',new CustomValidatePhone()],
            'province_code' => ['required'],
            

        ];
    }

    public function messages() {
        return [     
            'email.required' => 'Email không được bỏ trống',
            'name.required' => 'Tên không được bỏ trống',
            'phone.required' => 'Số diện thoại không được bỏ trống',
            'province_code.required' => 'Tỉnh/Thành phố không được bỏ trống',
           
        ];
    }
}
