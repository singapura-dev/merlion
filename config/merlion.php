<?php

return [
    'admin'     => [
        'api_routes_enabled' => env('MERLION_API_ROUTES_ENABLED', true),
        'route'              => [
            'prefix'     => 'admin',
            'middleware' => ['web', 'merlion'],
            'as'         => 'admin.',
            'domain'     => env("ADMIN_DOMAIN"),
            'redirect'   => '/',
        ],
        'title'              => env("ADMIN_NAME"),
        'attributes_html'    => [
//            'data-bs-theme-primary' => 'indigo',
//            'data-bs-theme' => 'light',
//            'data-bs-theme-base' => 'gray',
//            'data-bs-theme-font' => 'san-serif',
//            'data-bs-theme-radius' => 1,
        ],
    ],
    'providers' => [
        \Merlion\Addons\Auth\AuthServiceProvider::class,
    ],

];
