<?php

namespace Merlion\Components\Concerns\Admin;

/**
 * @method $this|static guard($guard) Set admin guard, like 'web'
 * @method $this|static username($username) Set login username field
 * @method $this|static usernameType($type) Set login username input type
 * @method $this|static usernameLabel($label) Set login username label
 * @method string getUsername() Get login username field
 * @method string getUsernameType() Get login username input type
 * @method string getUsernameLabel() Get login username label
 */
trait HasAuth
{
    public mixed $guard = null;
    protected mixed $hasLogin = true;
    protected mixed $loginUrl = null;

    public mixed $username = 'email';
    public mixed $usernameType = 'email';
    public mixed $usernameLabel = null;
    public mixed $canAccessUsing = null;

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

    public function canAccessPanel($user):bool
    {
        if(!empty($this->canAccessUsing)) {
            return call_user_func($this->canAccessUsing, $user);
        }

        if(app()->isLocal()) {
            return  true;
        }
        return false;
    }
}
