<?php

return [
    'route'     => [
        'prefix' => 'admin',
        'as'     => 'admin.',
        'guard'  => 'admin',
    ],
    'features'  => [
        'authentication' => true,
    ],
    'languages' => [
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
    'admin'     => [],
];
