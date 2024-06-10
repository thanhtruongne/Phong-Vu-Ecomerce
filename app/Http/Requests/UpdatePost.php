<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
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
            'content' => ['required'],
            'desc' => ['required'],
            'post_cateloge_id' => ['required'],
            'categories_sublist' => ['required'],
            'status' => ['required'],
            'image' => ['required'],
            'follow' => ['required'],
            'meta_title' => ['required'],
            'meta_keyword' => ['required'],
            'meta_desc' => ['required'],
            'meta_link' => ['required']
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tiêu đề  không được bỏ trống',
            'content.required' => 'Mục nội dung  không được bỏ trống',
            'desc.required' => 'Mục mô tả  không được bỏ trống',
            'post_cateloge_id.required' => 'Mục danh mục cha không được bỏ trống',
            'categories_sublist.required' => 'Mục danh mục con không được bỏ trống',
            'status.required' => 'Mục tình trạng  không được bỏ trống',
            'image.required' => 'Mục hình ảnh không được bỏ trống',
            'follow.required' => 'Mục theo dõi  không được bỏ trống',
            'meta_title.required' => 'Mục tiêu đề SEO  không được bỏ trống',
            'meta_keyword.required' => 'Mục từ khóa SEO  không được bỏ trống',
            'meta_desc.required' => 'Mục mô tả SEO  không được bỏ trống',
            'meta_link.required' => 'Mục đường dẫn SEO  không được bỏ trống',
        ];
    }
}
