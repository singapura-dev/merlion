<?php

declare(strict_types=1);

namespace Merlion\Components\Pages;

use Merlion\Components\Renderable;

class Login extends Renderable
{
    protected string $view = 'merlion::pages.login';
    public static $slogans = [
        "Great! Clean code, clean design, easy for customization. Thanks very much! ",
        "The theme is really great with an amazing customer support.",
    ];
}
