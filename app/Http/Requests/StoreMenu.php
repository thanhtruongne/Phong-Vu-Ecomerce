<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenu extends FormRequest
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
            'name' => ['required','unique:menu_cateloge,name,'.$this->id],
            'keyword' => ['required']
        ];
    }
    public function messages():array
    { 
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'name.unique' => 'Mục tên không được trùng',
            'keyword.required' => 'Mục từ khóa không được bỏ trống',
        ];
    }
}
