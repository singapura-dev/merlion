<?php
declare(strict_types=1);

namespace Merlion\Http\Controllers\Auth;

class LoginController
{

    public function showLogin()
    {
        return admin()->blank()->content(view('merlion::auth.login'))->render();
    }

    public function submitLogin()
    {
        $username = admin()->getUsername();
        request()->validate([
            $username  => ['required'],
            'password' => ['required'],
        ]);

        if ($this->auth()->attempt(request()->only($username, 'password'))) {
            return redirect()->intended(admin()->getContext('route.redirect'));
        }

        return back()->withErrors([
            $username => 'The provided credentials do not match our records.',
        ])->withInput(request()->only($username));
    }

    public function auth()
    {
        return admin()->auth();
    }

    public function logout()
    {
        $this->auth()->logout();
        return back();
    }
}
