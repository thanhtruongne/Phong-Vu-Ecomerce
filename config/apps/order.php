<?php 

return  [
    'filter_order' => [
        'confirm' => [
            'none' => 'Chọn trạng thái',
            'confirmed' => 'Đã xác nhận',
            'unconfirmed' => 'Chưa xác nhận',
       ],
       
        'payment' => [
            'none' => 'Chọn trạng thái TT',
            'paid' => 'Đã thanh toán',
            'unpaid' => 'Chưa thanh toán',
       ],
       'is_transport' => [
            0 => 'Chưa tạo GHTK label',
            1 => 'ĐH create GHTK label',
        ],
       'status_shipping' => [
        'none' => 'Chọn ',
        -1	=> "Hủy đơn hàng",
        1=>	"Chưa tiếp nhận",
        2=>	"Đã tiếp nhận",
        3=>	"Đã lấy hàng/Đã nhập kho",
        4=>	"Đang giao hàng",
        5=>	"Đã giao hàng/Chưa đối soát",
        6=>	"Đã đối soát",
        7=>	"Không lấy được hàng",
        8=>	"Hoãn lấy hàng",
        9=>	"Không giao được hàng",
        10=>	"Delay giao hàng",
        11=>	"Đã đối soát công nợ trả hàng",
        12=>	"Đã điều phối lấy hàng/Đang lấy hàng",
       ]
    ],
];