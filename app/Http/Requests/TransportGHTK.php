<?php

namespace App\Http\Requests;

use App\Rules\CustomValidateOrderGHTK;
use Illuminate\Foundation\Http\FormRequest;

class TransportGHTK extends FormRequest
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
            'pick_money' => ['required'],
            'is_freeship' => ['required'],
            'is_free_test' => [new CustomValidateOrderGHTK($this->input('pick_money'),$this->input('value'),$this->input('shipcost'))]
        ];
    }

    public function messages(): array
    {
        return [
            'pick_money' => 'Mục tiền COD có lỗi xảy ra',
            'is_freeship' => 'Mục loại vận chuyển có lỗi xảy ra',
        ];
    }
}
