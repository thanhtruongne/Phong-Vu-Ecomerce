<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAdmin extends FormRequest
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
            'fullname' => ['required'],
            'email' => ['required','email'],
            'password' => ['required','max:20','min:10','confirmed'],
            'birthday' => ['required'],
            'phone' => ['required'],
            'role' => ['required'],
            'thumb' => ['required','image','mimes:png,jpg,jpeg'],
            'province_code' => ['required'],
            'district_code' => ['required'],
            'ward_code' => ['required'],
            'address' =>['required'],
            'desc' =>['required']
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Mục tên không được bỏ trống',
            'fullname.required' => 'Mục họ không được bỏ trống',
            'email.required' => 'Mục email không được bỏ trống',
            'email.email' => 'Mục email không đúng định dạng',
            'password.required' => 'Mục mật khẩu không được bỏ trống',
            'password.min' => 'Mục mật khẩu có độ dài tối thiếu 10 kí tự',
            'password.max' => 'Mục mật khẩu có độ dài tối đa 20 kí tự',
            'password.confirmed' => 'Mục xác nhận mật khẩu không đúng',
            'birthday.required' =>'Mục ngày sinh không được bỏ trống',
            'role.required' => 'Mục role không được bỏ trống',
            'phone.required' => 'Mục sdt không được bỏ trống',
            'thumb.required' => 'Mục hình ảnh bắt buộc',
            'thumb.image' => 'Bắt buộc là hình ảnh',
            'thumb.mimes' => 'Có dạng bắt buộc jpg,jpeg,png',
            'province_code.required' => 'Mục thành phố không được bỏ trống',
            'district_code.required' => 'Mục quận không được bỏ trống',
            'ward_code.required' => 'Mục huyện không được bỏ trống',
            'address.required' =>'Mục địa chỉ không được bỏ trống',
            'desc.required' =>'Mục ghi chú không được bỏ trống',
        ];
    }
}
