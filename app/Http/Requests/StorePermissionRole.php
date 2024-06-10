<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRole extends FormRequest
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
            'name' => ['required','unique:roles,name,'.$this->id],
        ];
    }
    public function messages():array
    { 
        return [
            'name.required' => 'Mục vai trò không được bỏ trống',
            'name.unique' => 'Mục vai trò không được trùng',
        ];
    }
}
