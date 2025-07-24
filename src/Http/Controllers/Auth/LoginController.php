<?php

namespace Merlion\Http\Controllers\Auth;

use Merlion\Components\Pages\Login;

class LoginController
{
    public function showLogin()
    {
        if ($this->auth()->check()) {
            return redirect(admin()->getHomeUrl());
        }
        return admin()->full()->content(Login::make())->render();
    }

    public function submitLogin()
    {
        $username = Login::$username;
        request()->validate([
            $username  => ['required'],
            'password' => ['required'],
        ]);

        if ($this->auth()->attempt(request()->only($username, 'password'))) {
            return redirect()->intended(admin()->getHome());
        }

        return back()->withErrors([
            $username => 'The provided credentials do not match our records.',
        ])->withInput(request()->only($username));
    }

    public function logout()
    {
        $this->auth()->logout();
        return back();
    }

    protected function auth()
    {
        return auth(config('merlion.route.guard'));
    }
}
