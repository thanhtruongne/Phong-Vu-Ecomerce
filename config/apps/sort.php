<?php

return [
    'sort' => [
        [
            'id' => 1,
            'value' => 'DESC',
            'type' => 'SORT_BY_PRICE',
            'title' => 'Giá giảm dần'
        ],
        [
            'id' => 2,
            'value' => 'ASC',
            'type' => 'SORT_BY_PRICE',
            'title' => 'Giá tăng dần'
        ],
        [
            'id' => 3,
            'value' => 'created_at',
            'type' => 'SORT_BY_CREATED',
            'title' => 'Sản phẩm tăng dần'
        ],
        [
            'id' => 4,
            'value' => 'DESC',
            'type' => 'SORT_BY_TOP_SALE_QUANTITY',
            'title' => 'Sản phẩm bán chạy'
        ],
    ],
    'name_sort_symbol' => [
        'price_lte' => 'price_lte',
        'price_gte' => 'price_gte',
        'thuonghieu' => 'thuonghieu',
        'sort' => 'sort',
        'order' => 'order',
    ]
];