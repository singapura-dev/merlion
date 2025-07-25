<?php

namespace Merlion\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class MerlionAuthenticate
{

    protected Auth $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Auth  $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $this->authenticate($request);

        return $next($request);
    }

    /**
     * @throws AuthenticationException
     */
    protected function authenticate($request): void
    {
        $guard = admin()->getGuard();
        if ($this->auth->guard($guard)->check()) {
            $this->auth->shouldUse($guard);
            return;
        }
        $this->unauthenticated($request, [$guard]);
    }

    /**
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.',
            $guards,
            $request->expectsJson() ? null : $this->redirectTo($request),
        );
    }

    public function redirectTo(Request $request): ?string
    {
        return admin()->getLoginRedirect();
    }
}
