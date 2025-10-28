<?php

namespace Merlion\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Merlion\Components\Layouts\Admin;

class Authenticate extends Middleware
{
    protected Admin $admin;

    protected function authenticate($request, array $guards): void
    {
        $this->admin = admin($guards[0]);

        $guard = $this->admin->auth();

        if (!$guard->check()) {
            $this->unauthenticated($request, [$guard->getName()]);
        }

        $this->auth->shouldUse($this->admin->getGuard());
    }

    protected function redirectTo($request): ?string
    {
        return $this->admin->getLoginUrl();
    }
}
