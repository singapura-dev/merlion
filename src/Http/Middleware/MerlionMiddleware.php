<?php

declare(strict_types=1);

namespace Merlion\Http\Middleware;

use Closure;
use Context;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class MerlionMiddleware
{
    public function handle(Request $request, Closure $next, ...$id): Response
    {
        $id = $id[0] ?? 'admin';
        Context::add('admin_id', $id);
        if ($csp = $request->header('x-csp-nonce')) {
            admin()->cspNonce($csp);
        }
        admin()->updateLanguage();
        if (!$request->ajax()) {
            Paginator::useBootstrapFive();
        }
        admin()->served();
        return $next($request);
    }
}
