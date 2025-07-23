<?php

declare(strict_types=1);

namespace Merlion\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerlionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($csp = $request->header('x-csp-nonce')) {
            admin()->cspNonce($csp);
        }
        admin()->updateLanguage();
        return $next($request);
    }
}
