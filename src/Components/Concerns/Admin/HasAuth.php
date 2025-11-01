<?php

namespace Merlion\Components\Concerns\Admin;

/**
 * @method $this|static guard($guard) Set admin guard, like 'web'
 */
trait HasAuth
{
    public mixed $guard = null;
    protected mixed $hasLogin = true;
    protected mixed $loginUrl = null;

    public mixed $username = 'email';
    public mixed $usernameType = 'email';

    public function loginUrl($url): static
    {
        $this->loginUrl = $url;
        return $this;
    }

    public function getLoginUrl(): string
    {
        return $this->loginUrl ?? $this->getRoute('auth.login');
    }

    public function disableLogin(): static
    {
        $this->hasLogin = false;
        return $this;
    }

    public function hasLogin(): bool
    {
        return $this->hasLogin;
    }

    public function auth()
    {
        return auth()->guard($this->getGuard());
    }

    public function getGuard(): string
    {
        return $this->guard ?: config('auth.defaults.guard');
    }
}
