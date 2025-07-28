<?php

declare(strict_types=1);

namespace Merlion\Components\Pages;

use Merlion\Components\Renderable;

class Login extends Renderable
{
    public $view = 'merlion::pages.login';

    public static array $slogans = [
        "Great! Clean code, clean design, easy for customization. Thanks very much! ",
    ];

    public mixed $username = 'email';
    public mixed $usernameLabel = '';

    public function getUsernameLabel(): string
    {
        if (!empty($this->usernameLabel)) {
            return $this->evaluate($this->usernameLabel);
        }
        return __('merlion::base.email');
    }
}
