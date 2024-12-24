<?php

return [
    'theme' => [
        'fontFamily' => [
            'sans' => ['ui-sans-serif', 'system=ui']
        ]
    ],
    'content' => [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    'theme' => [
        'extend' => [
            'screens' => [
                'mobile' => ['max' => '480px'],
                'tablet' => ['max' => '1023px', 'min' => '481px'],
                'desktop' => ['min' => '1024px'],
            ],
            'colors' => [
                'primary' => "#".env('WARNA_UTAMA'),
                'primary-transparent' => "#".env('WARNA_UTAMA')."20",
                'primary-transparent-2' => "#".env('WARNA_UTAMA')."60",
            ]
        ]
    ],
];