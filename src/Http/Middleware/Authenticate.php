<?php

namespace Merlion\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        $guard = admin()->auth();

        if (!$guard->check()) {
            $this->unauthenticated($request, $guards);
        }

        $this->auth->shouldUse(admin()->getGuard());
    }

    protected function redirectTo($request): ?string
    {
        return admin()->getLoginUrl();
    }
}
