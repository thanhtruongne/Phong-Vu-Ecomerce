<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WidgetStore extends FormRequest
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
            'name' => ['required'],
            'keyword' => ['required'],
            'desc' => ['required'],
            'album' => ['required'],
            'model' => ['required'],
            'model_id' => ['required'],
            'short_code' => ['required'],
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tiêu đề  không được bỏ trống',
            'keyword.required' => 'Mục keyword  không được bỏ trống',
            'desc.required' => 'Mục desc  không được bỏ trống',
            'album.required' => 'Mục album  không được bỏ trống',
            'model.required' => 'Mục model  không được bỏ trống',
            'model_id.required' => 'Mục mode_id  không được bỏ trống',
            'short_code.required' => 'Mục short_code  không được bỏ trống',
        ];
    }
}
