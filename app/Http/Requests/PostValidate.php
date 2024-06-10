<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostValidate extends FormRequest
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
            'name' => ['required','unique:post_translate,name',$this->id],
            'meta_link' => ['required']
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tiêu đề  không được bỏ trống',
            'name.unique' => 'Mục tiêu đề  không được trùng',
            'meta_link.required' => 'Mục canonical không được bỏ trống',
        ];
    }
}
