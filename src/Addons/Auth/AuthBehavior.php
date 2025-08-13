<?php
declare(strict_types=1);

namespace Merlion\Addons\Auth;

use Merlion\Support\Behavior;

class AuthBehavior extends Behavior
{
    protected mixed $username = 'email';

    protected mixed $usernameLabel = null;
    protected mixed $usernamePlaceholder = null;

    public function username($username): mixed
    {
        $this->username = $username;
        return $this->getHost();
    }

    public function getUsername(): string
    {
        return evaluate($this->username, $this->getHost());
    }

    public function usernameLabel($username): mixed
    {
        $this->usernameLabel = $username;
        return $this->getHost();
    }

    public function getUsernamePlaceholder(): string
    {
        return evaluate($this->usernamePlaceholder ?: $this->defaultUsernamePlaceholder(), $this->getHost());
    }

    public function usernamePlaceholder($usernamePlaceholder): mixed
    {
        $this->usernamePlaceholder = $usernamePlaceholder;
        return $this->getHost();
    }

    public function getUsernameLabel(): string
    {
        return evaluate($this->usernameLabel ?: $this->defaultUsernameLabel(), $this->getHost());
    }

    public function authRoutes(): void
    {
        require __DIR__ . '/routes/auth.php';
    }

    protected function defaultUsernameLabel(): string
    {
        return __('merlion_auth::auth.email');
    }

    protected function defaultUsernamePlaceholder(): string
    {
        return __('merlion_auth::auth.input_email');
    }
}
