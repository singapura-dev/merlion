<?php

return [
    'admin' => [
        'route' => [
            'prefix' => 'admin',
            'as' => 'admin.',
            'domain' => env("ADMIN_DOMAIN"),
            'redirect' => '/'
        ],
        'title' => 'Admin',
        'attributes_html' => [
            'data-bs-theme-primary' => 'indigo',
            'data-bs-theme' => 'light',
            'data-bs-theme-base' => 'gray',
            'data-bs-theme-font' => 'serif',
            'data-bs-theme-radius' => 0.5,
        ],
    ],
    'providers' => [
        \Merlion\Addons\Auth\AuthServiceProvider::class
    ]
];
