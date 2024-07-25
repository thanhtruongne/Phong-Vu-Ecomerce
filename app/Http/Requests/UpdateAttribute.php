<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttribute extends FormRequest
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
            'canonical' => ['required','unique:router,canonical,'.$this->id],
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'canonical.required' => 'Mục canonical không được bỏ trống',
            'canonical.unique' => 'Mục canonical không được trùng',
        ];
    }
}
