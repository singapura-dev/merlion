<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns\Admin;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * @method string getAs() get route name prefix
 * @method string getPrefix() get route prefix
 * @method string getHomeUrl() get home url
 * @method $this back(string|Closure $url) Set back url
 */
trait HasRoute
{
    public mixed $guard = null;
    public mixed $prefix = null;
    public mixed $as = null;
    public mixed $back = null;
    public mixed $loginRedirect = null;
    public mixed $home = null;

    public function getGuard()
    {
        if (empty($this->guard)) {
            return auth()->guard();
        }

        return $this->evaluate($this->guard);
    }

    public function routes(): static
    {
        $this->routeGroup(function () {
            require __DIR__ . '/../../../../routes/auth.php';
            $this->routeAuthedGroup(function () {
                require __DIR__ . '/../../../../routes/api.php';
            });
        });
        return $this;
    }

    public function routeGroup($callback, $group = []): static
    {
        Route::group(array_merge([
            'middleware' => ['web', 'merlion'],
            'prefix'     => $this->getPrefix(),
            'as'         => $this->getAs(),
        ], $group), $callback);
        return $this;
    }

    public function routeAuthedGroup($callback, $group = []): static
    {
        Route::group(array_merge(['middleware' => 'merlion_auth'], $group), $callback);
        return $this;
    }

    public function route($name, ...$args)
    {
        if (Str::isUrl($name)) {
            return $name;
        }

        $route_name = $name;

        if (!Str::startsWith($route_name, $this->getAs())) {
            $route_name = $this->getAs() . $route_name;
        }

        return route($route_name, ...$args);
    }

    public function getHome(): string
    {
        if (empty($this->home)) {
            return url($this->prefix);
        }
        return $this->evaluate($this->home);
    }

    public function getLoginRedirect(): string
    {
        if (empty($this->loginRedirect)) {
            return url($this->prefix . '/login');
        }
        return $this->evaluate($this->loginRedirect);
    }

}
