<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStore extends FormRequest
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
            'slide.thumbnail' => ['required'],
            'slide.name' => ['required'],
            'slide.canonical' => ['required'],
            'name' => ['required'],
            'keyword' => ['required']
        ];
    }
    public function messages():array
    { 
        return [
            'slide.thumbnail.required' => 'Mục thumbnail không được bỏ trống',
            'slide.name.required' => 'Mục tên thumbnail không được bỏ trống',
            'slide.canonical.required' => 'Mục canonical không được bỏ trống',
            'name.required' => 'Mục name không được bỏ trống',
            'keyword.required' => 'Mục từ khóa không được bỏ trống',
        ];
    }
}
