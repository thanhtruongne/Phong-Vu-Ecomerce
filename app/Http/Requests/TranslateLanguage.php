<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class TranslateLanguage extends FormRequest
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
            'translate_name' => ['required'],
            'translate_meta_link' => ['required',
                function($attribute,$value,$fail) {
                  $option = $this->input('option');
                  $exists = DB::table('routers')
                  ->where('canonical',$value)
                  ->where('id','<>',+$option['detach_id'])
                  ->where('languages_id','<>',+$option['languages_id'])
                  ->exists();

                  if($exists) {
                    $fail('Đường dẫn đã tồn tại !!!');
                  }
                }
            ]
        ];
    }

    public function messages():array 
    {
        return [
            'translate_name.required' => 'Mục chuyển dổi bản dịch name không dược bỏ trống',
            'translate_meta_link.required' => 'Mục link bản dịch name không dược bỏ trống',
            'translate_meta_link.unique' => 'Mục link bản dịch name không dược trùng'
        ];
    }
}
