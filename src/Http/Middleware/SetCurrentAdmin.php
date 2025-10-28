<?php
declare(strict_types=1);

namespace Merlion\Http\Middleware;

use Closure;
use Merlion\AdminManager;

class SetCurrentAdmin
{
    public function handle($request, Closure $next, $id = null)
    {
        app(AdminManager::class)->setCurrentAdmin($id);
        admin()->callHooks('serving', admin());
        return $next($request);
    }
}
