<?php

namespace App\Http\Requests\Frontend;

use App\Rules\CustomValidateEmail;
use App\Rules\CustomValidateFullName;
use App\Rules\CustomValidatePhone;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required','email',new CustomValidateEmail()],
            'password' => ['required'],

        ];
    }

    public function messages() {
        return [
            
            'email.required' => 'Email không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống'
        ];
    }
}
