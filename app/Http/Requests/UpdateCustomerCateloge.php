<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerCateloge extends FormRequest
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
            'name' => ['required','unique:customer_cateloge,name,'.$this->id],
            'keyword' => ['required'],
            'desc' =>['required']
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'name.unique' => 'Mục tên không được trùng',
            'keyword.required' => 'Mục từ khóa không được bỏ trống',
            'desc.required' =>'Mục ghi chú không được bỏ trống',
        ];
    }
}
