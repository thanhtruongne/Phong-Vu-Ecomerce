<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
            'name' => ['required',],
            'meta_link' => ['required'],
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'meta_link.required' => 'Mục canonical không được bỏ trống',
        ];
    }
}
