<?php

namespace App\Http\Requests\Backend\Promotion;

use App\Rules\CustomDateAfterPromotion;
use Illuminate\Foundation\Http\FormRequest;

class StorePromotion extends FormRequest
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
        $rules = [
            'name' => ['required'],
            'code' => ['required','unique:promotion'],
            'startDate' =>['required','date_format:d/m/Y H:i']
        ];

        //custom phần Validator  về time custom_after vào phần provider 
        if(!$this->input('neverEndDate')) {
            $rules['endDate'] = ['required','date_format:d/m/Y H:i',new CustomDateAfterPromotion($this->input('startDate'))];
        }
        return $rules;
           
    }

    public function messages() {
        $messages = [
            'name.required' => 'Mục tên khuyến mãi không được bỏ trống',
            'code.required' => 'Mục code khuyến mãi không được bỏ trống',
            'code.unique' => 'Mục code khuyến mãi không được trùng',
            'startDate.required' => 'Mục ngày bắt đầu không được bỏ trống',
            'startDate.date_format' => 'Mục ngày bắt đầu không đúng dịnh dạng',
            'endDate.required'=> 'Mục ngày kết thúc không được bỏ trống',
        ];
        return $messages;
    }
}
