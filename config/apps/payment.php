<?php 
return [
    'method_payment' => [
        'vnPay' => [
            'title' => 'Thanh toán bằng VN Pay',
            'value' => 'vnpay',
            'logo' => 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900651/vnpay-logo-CCF12E3F02-seeklogo.com_iqf7ks.png',
            'desc' => 'Thanh toán Internet Banking,VN Pay ...'
        ],
        'zalo' => [
            'title' => 'Thanh toán bằng Zalo Pay',
            'value' => 'zalo',
            'logo' => 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900961/ZaloPay-vuong_zxeof9.png',
            'desc' => 'Thanh toán Zalo Pay QR ...'
        ],
        'momo' => [
            'title' => 'Thanh toán bằng Momo',
            'value' => 'momo',
            'logo' => 'https://res.cloudinary.com/dcbsaugq3/image/upload/v1719900882/momo_icon_square_pinkbg_RGB_jauyz1.png',
            'desc' => 'Thanh toán Momo QR ...'
        ],
        'cod' => [
            'title' => 'Thanh toán khi nhận hàng',
            'logo' => '',
            'value' => 'cod',
            'desc' => ''
        ],
    ],
    'status_order' => [
        'unpaid' => [
            'title' => 'Chưa thanh toán',
            'value' => 'unpaid',
        ],
        'paid' => [
            'title' => 'Đã thanh toán',
            'value' => 'paid',
        ],
    ],
    'shippinh_status_ghtk' => [

    ],
    'shipping' => [
        'success' => 'Đã giao hàng',
        'cancel' => 'Đơn hàng hủy',
        'process' => 'Đang giao hàng',
        'pending' => 'Chưa tiếp nhận',
    ],
    'payment_confirm' => [
        'confirmed' => [
            'title' => 'Đã xác nhận',
            'value' => 1,
        ],
        'unconfirmed' => [
            'title' => 'Chờ xác nhận',
            'value' => '2',
        ],
    ],
    'shipping_rule' => [
        [
            'id' => 1,
            'title' => 'Đã tiếp nhận',
        ],
        [
            'id' => '2',
            'title' => 'Giao hàng hỏa tốc',
        ],
    ],
    'pick_address' => [
        'name' => 'Nguyễn',
        'provinces' => 'Hồ Chí Minh',
        'district' => 'Quận 5',
        'ward' => 'Phường 6',
        'tel' => '099311241',
        'address' => 'Ta Quang Buu'
    ],
    'is_freeship' => [
        0 => 'Thu tiền hàng hóa và phí ship',
        1 => 'Thu tiền hàng hóa không bao gòm phí ship',
    ]
];