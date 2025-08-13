<?php
declare(strict_types=1);

namespace Merlion\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Context;
use Merlion\Components\Layouts\Admin;

class SetCurrentAdmin
{
    public function handle($request, Closure $next, $id)
    {
        Context::add('merlion_id', $id ?? 'admin');
        Admin::callStaticHooks('serving');
        admin()->callHooks('serving', admin());
        return $next($request);
    }
}
