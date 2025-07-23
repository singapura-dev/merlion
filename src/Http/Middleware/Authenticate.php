<?php

namespace Merlion\Http\Middleware;

use Illuminate\Http\Request;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    protected function authenticate($request, array $guards): void
    {
        $guard = config('merlion.route.guard');
        if ($this->auth->guard($guard)->check()) {
            $this->auth->shouldUse($guard);
            return;
        }
        $this->unauthenticated($request, [$guard]);
    }

    public function redirectTo(Request $request): ?string
    {
        return route(config('merlion.route.as') . 'login');
    }
}
