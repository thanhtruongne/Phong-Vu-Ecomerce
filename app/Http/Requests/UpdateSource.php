<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSource extends FormRequest
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
            'name' => ['required','unique:source,name',$this->id],
            'keyword' => ['required'],
            'desc' => ['required'],
        ];
    }


    public function messages() {
        return [
            'name.required' => 'Mục tên nhóm không được bỏ trống',
            'name.unique' => 'Mục tên không được trùng',
            'desc.required' => 'Mục mô tả không được bỏ trống',
            'keyword.required' => 'Mục từ khóa không được bỏ trống',
        ];
    }
}
