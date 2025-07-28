<?php

return [
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
    'admin'     => [
        'prefix' => 'admin',
        'as'     => 'admin.',
        'guard'  => 'web',
    ],
];
