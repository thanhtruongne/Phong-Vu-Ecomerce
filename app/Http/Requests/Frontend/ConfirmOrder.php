<?php

namespace App\Http\Requests\Frontend;

use App\Rules\CustomValidateEmail;
use App\Rules\CustomValidateFullName;
use App\Rules\CustomValidatePhone;
use App\Rules\customValitePriceMethod;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmOrder extends FormRequest
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
            'method' => ['required'],
            'total' => [new customValitePriceMethod($this->input('method'))]

        ];
    }

    public function messages() {
        return [
            'method.required' => 'Phương thức thanh toán không được bỏ trống'
        ];
    }
}
