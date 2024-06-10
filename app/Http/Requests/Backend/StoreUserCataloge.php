<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserCataloge extends FormRequest
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
            'name' => ['required'],
            'desc' => ['required'],
        ];
    }


    public function messages() {
        return [
            'name.required' => 'Mục tên nhóm không được bỏ trống',
            'desc.required' => 'Mục mô tả không được bỏ trống',
        ];
    }
}
