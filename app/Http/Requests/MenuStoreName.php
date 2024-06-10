<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreName extends FormRequest
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
            'menu_cateloge_id' => ['required','gt:0'],
            'menu.name' => ['required']
            
        ];
    }
    public function messages():array
    { 
        return [
            'menu_cateloge_id.required' => 'Mục menu vị trí không được bỏ trống',
            'menu.name.required' => 'Mục tên các menu không được bỏ trống'
        ];
    }
}
