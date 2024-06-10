<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleGenerate extends FormRequest
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
            'name' => ['required','unique:generate_module,name,'.$this->id],
            'function_name' => ['required'],
            'path' => ['required'],
            'module_type' => ['required','not_in:0'],
            'schema' => ['required'],
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tên module không được bỏ trống',
            'name.unique' => 'Mục tên module không được trùng',
            'path.required' => 'Mục đường dẫn không được bỏ trống',
            'function_name.required' => 'Mục tên chức năng không được bỏ trống',
            'module_type.required' => 'Mục type module bắt buộc chọn',
            'module_type.not_in' => 'Mục type module bắt buộc chọn trường có giá trị',
            'schema.required' => 'Mục schema modube không được bỏ trống',
        ];
    }
}
