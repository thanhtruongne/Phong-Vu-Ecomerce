<?php 

namespace App\Classes;

class System {

 
    //hàm luu các thông số và label các input dữ liệu cấu hình chung
    public function config() {
        $data['homepage_index'] = [
            'label' => 'Thông tin chung',
            'desc' => 'Tạo và cập nhật các chi tiết thông số trang web.',
            'value' => [
                'organization' => ['type' => 'text' , 'label' => 'Tổ chức'],
                'brand' => ['type' => 'text' , 'label' => 'Thương hiệu'],
                'slogan' => ['type' => 'text' , 'label' => 'SLOGAN'],
                'Logo' => ['type' => 'image' , 'label' => 'Logo' , 'placeholder' => 'Ấn vào ô input để tải ảnh...'],
                'Coypyright' => ['type' => 'textarea' , 'label' => 'Copyright'],
                'webActive' => [
                    'type' => 'select',
                    'label' => 'Tình trạng hoạt động',
                    'val' => [
                        '1' => 'Hoạt động',
                        '2' => 'Bảo trì hệ thống',
                        '3' => 'Tạm ngưng dịch vụ'
                    ]
                ]
            ]
        ];
        $data['contact'] = [
            'label' => 'Thông tin liên lạc',
            'desc' => 'Tạo và cập nhật các thông tin hỗ trợ ,liên lạc.',
            'value' => [
                'office' => ['type' => 'text' , 'label' => 'Văn phòng'],
                'address' => ['type' => 'text' , 'label' => 'Địa chỉ'],
                'branch' => ['type' => 'text' , 'label' => 'Chi nhánh'],
                'hotline' => ['type' => 'text' , 'label' => 'Liên hệ'],
                'Email' => ['type' => 'email' , 'label' => 'Email'],
                'tax' => ['type' => 'text' , 'label' => 'Mã sỗ thuế'],
                'web' => ['type' => 'text' , 'label' => 'Website'],
                
            ]
        ];

        
        $data['seo'] = [
            'label' => 'Câu hình SEO',
            'desc' => 'Cập nhật chủ để và hình thức SEO trang web',
            'value' => [
                'meta_title' => ['type' => 'text' , 'label' => 'Tiêu đề SEO'],
                'meta_desc' => ['type' => 'text' , 'label' => 'Nội dung SEO'],
                'meta_keyword' => ['type' => 'text' , 'label' => 'Từ khóa SEO'],
                'meta_images' => ['type' => 'image' , 'label' => 'Hình ảnh SEO','placeholder' => 'Ấn vào ô input để tải ảnh...'],
            ]
        ];
        return $data;
    }
}