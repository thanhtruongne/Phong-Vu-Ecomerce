<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguages extends FormRequest
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
            'desc' => ['required','max:30'],
            'canonical' => ['required','unique:languages,canonical,id'],
            'image' => ['required'],
        ];
    }
    
    public function messages(): array
     {
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'desc.required' => 'Mục mô tả không được bỏ trống',
            'desc.max' => 'Mục tên tối đa 30 kí tự',
            'canonical.required' => 'Mục canonical không được bỏ trống',
            'canonical.unique' => 'Mục canonical không được trùng',
            'image.required' => 'Mục hình ảnh không được bỏ trống',

        ];
    }
}
