<?php

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Merlion\Http\Middleware\Authenticate;

return [
    'admin'     => [
        'api_routes_enabled' => env('MERLION_API_ROUTES_ENABLED', true),
        'route'              => [
            'middlewares'      => [
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
            ],
            'auth_middlewares' => [
                Authenticate::class,
            ],
            'domain'           => env("ADMIN_DOMAIN"),
            'redirect'         => '/',
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
