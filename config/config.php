<?php

return [
    'route'        => [
        'prefix' => 'admin',
        'as'     => 'admin.',
        'guard'  => 'admin',
    ],
    'auth_enabled' => true,
    'auth'         => [
        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'users',
            ],
        ],
    ],
    'languages'    => [
        [
            'key'   => 'en',
            'label' => 'English',
            'flag'  => 'us',
        ],
        [
            'key'   => 'zh_CN',
            'label' => '简体中文',
            'flag'  => 'cn',
        ],
    ],
];
