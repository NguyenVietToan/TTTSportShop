<?php
    return [
        'image_valid_extension' => ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG','ico', 'ICO', 'gif', 'GIF'],

        'video_valid_extension'	=> ['mp4', 'MP4', 'flv', 'FLV', 'mkv', 'MKV'],

        'days' => [1, 31],

        'months' => [1, 12],

        'years' => [1900, 2017],

        'sorts' => [
            'vi'    => [
                'time_down'     => 'Theo sản phẩm mới nhất',
                'price_up'      => 'Giá tăng dần',
                'price_down'    => 'Giá giảm dần',
                'alpha_up'      => 'Tên a-z',
                'alpha_down'    => 'Tên z-a'
            ],
            'en'    => [
                'time_down'     => 'Product newer to older',
                'price_up'      => 'Price increase',
                'price_down'    => 'Price decrease',
                'alpha_up'      => 'Name a-z',
                'alpha_down'    => 'Name z-a'
            ]
        ],

        'genders' => [
            'vi'    => [
                '1' => 'Nam', '2' => 'Nữ', '3' => 'Nam và Nữ', '4' => 'Trẻ em'
            ],
            'en'    => [
                '1' => 'Male', '2' => 'Female', '3' =>"Male and Female", '4' => 'Kid'
            ],
        ],
        'gender_admin'   => [
            '1' => 'Nam', '2' => 'Nữ', '3' => 'Nam và Nữ', '4' => 'Trẻ em'
        ]
        ,

        'status_orders' => [
            0 => 'Chờ xử lý',
            1 => 'Đang xử lý',
            2 => 'Đang chuyển hàng',
            3 => 'Đã thành công',
            4 => 'Đã hủy'
        ],

        'status_shipping' => [
            0 => 'Đang chuyển hàng',
            1 => 'Đã chuyển',
        ],

        'creator' => [
            1   => 'Khách hàng',
            2   => 'Admin'
        ],

        'detail_status_shipping' => [
            0   => 'Đã hủy',
            1   => 'Thành công'
        ]

    ]

?>