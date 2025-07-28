<?php

declare(strict_types=1);

namespace Merlion\Components\Pages;

use Merlion\Components\Renderable;

class Login extends Renderable
{
    public $view = 'merlion::pages.login';

    public static mixed $username = '';
    public static mixed $usernameLabel = '';

    public function getUsernameLabel(): string
    {
        if (!empty(static::$usernameLabel)) {
            return $this->evaluate(static::$usernameLabel);
        }
        return __('merlion::base.email');
    }

    public function getUsername(): string
    {
        if (!empty(static::$username)) {
            return $this->evaluate(static::$username);
        }
        return 'email';
    }
}
