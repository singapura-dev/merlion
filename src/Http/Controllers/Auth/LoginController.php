<?php

namespace Merlion\Http\Controllers\Auth;

use Merlion\Components\Pages\Login;

class LoginController
{
    public function showLogin()
    {
        return admin()->full()->content(Login::make())->render();
    }

    public function submitLogin()
    {
        admin()->success('登录成功');
        return back();
    }
}
