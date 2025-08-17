<?php

return [
    'admin' => [
        'route' => [
            'prefix' => 'admin',
            'as' => 'admin.',
            'domain' => env("ADMIN_DOMAIN"),
            'redirect' => '/'
        ],
        'title' => env("ADMIN_NAME"),
        'attributes_html' => [
//            'data-bs-theme-primary' => 'indigo',
//            'data-bs-theme' => 'light',
//            'data-bs-theme-base' => 'gray',
//            'data-bs-theme-font' => 'san-serif',
//            'data-bs-theme-radius' => 1,
        ],
    ],
    'providers' => [
        \Merlion\Addons\Auth\AuthServiceProvider::class
    ]
];
