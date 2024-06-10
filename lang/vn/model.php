<?php 

return [
    'model' => [
        'PostCateloge' => [
            'name' => 'Nhóm bài viết',
            'model' => 'PostCateloge'
        ],
        'Post' => [
            'name' => 'Bài viết',
            'model' => 'Post'
        ],
        'ProductCateloge' => [
            'name' => 'Nhóm sản phẩm',
            'model' => 'ProductCateloge'
        ],
        'Product' => [
            'name' => 'Sản phẩm',
            'model' => 'Product'
        ],
    ],
    'dropDown' => [
        'dropdown' => 'Drop down single',
        'MegaDown' => 'Drop MegaDown'
    ],
    'promotion' => [
        'order_amount_range' => 'Chiết khấu theo tổng giá trị đơn hàng',
        'product_and_qualnity' => 'Chiết khấu theo từng sản phẩm',
        'product_and_range' => 'Chiết khấu theo từng số lượng sản phẩm',
        'discount_by_qualnity' => 'Giảm giá khi mua sản phẩm',
    ],
    'promotion_product' => [
        'Product' => 'Theo sản phẩm',
        'ProductCateloge' => 'Theo các loại sản phẩm'
    ],
    'CustomerCateloge' => [
        [
            'id' => 'staff_take_care',
            'name' => 'Nhân viên chăm sóc và hỗ trợ'
        ],
        [
            'id' => 'customer_birthday',
            'name' => 'Theo ngày sinh'
        ],
        [
            'id' => 'customer_group',
            'name' => 'Theo nhóm khách hàng'
        ],
        [
            'id' => 'customer_gender',
            'name' => 'Theo giới tính'
        ],
    ],
    'gender' => [
         [
            'name' => 'Nam',
            'id' => 1
         ],
         [
            'name' => 'Nữ',
            'id' => 2
         ],
         [
            'name' => 'Khác',
            'id' => 3
         ],
    ],
    'day' => array_map(function($val) {
        return ['id' => $val -1 , 'name' => $val];
    },range(1,31))
];