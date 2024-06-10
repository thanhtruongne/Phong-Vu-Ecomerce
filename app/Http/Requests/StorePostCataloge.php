<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostCataloge extends FormRequest
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
            'name' => ['required','unique:post_cataloge_translate,name'],
            'content' => ['required'],
            'description' => ['required'],
            'parent_id' => ['required'],
            'status' => ['required'],
            'image' => ['required'],
            'follow' => ['required'],
            'meta_title' => ['required'],
            'meta_keyword' => ['required'],
            'meta_desc' => ['required'],
            'meta_seo_link' => ['required']
        ];
    }

    public function messages():array
    { 
        return [
            'name.required' => 'Mục tiêu đề nhóm không được bỏ trống',
            'name.unique' => 'Mục tiêu đề nhóm không được trùng',
            'content.required' => 'Mục nội dung nhóm không được bỏ trống',
            'description.required' => 'Mục mô tả nhóm không được bỏ trống',
            'parent_id.required' => 'Mục danh mục nhóm không được bỏ trống',
            'status.required' => 'Mục tình trạng nhóm không được bỏ trống',
            'image.required' => 'Mục hình ảnh không được bỏ trống',
            'follow.required' => 'Mục theo dõi nhóm không được bỏ trống',
            'meta_title.required' => 'Mục tiêu đề SEO nhóm không được bỏ trống',
            'meta_keyword.required' => 'Mục từ khóa SEO nhóm không được bỏ trống',
            'meta_desc.required' => 'Mục mô tả SEO nhóm không được bỏ trống',
            'meta_seo_link.required' => 'Mục đường dẫn SEO nhóm không được bỏ trống',
        ];
    }
}
