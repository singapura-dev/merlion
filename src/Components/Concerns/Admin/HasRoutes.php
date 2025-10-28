<?php

namespace Merlion\Components\Concerns\Admin;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\Serializers\Native;
use Merlion\Http\Controllers\Home;
use Merlion\Http\Middleware\SetCurrentAdmin;

/**
 * @method static path($path) Set prefix
 * @method array getDomains()
 * @method array getAuthenticatedRoutes()
 * @method array getRoutes()
 * @method string getPath()
 * @method string getHome()
 * @method string getHomeUrl()
 */
trait HasRoutes
{
    /**
     * @var array<Closure | Native>
     */
    public array $routes = [];

    /**
     * @var array<Closure | Native>
     */
    public array $authenticatedRoutes = [];

    public array $middleware = [];

    public array $authMiddleware = [];

    public mixed $path = '';

    public mixed $domains = '';

    public mixed $home = Home::class;
    public mixed $homeUrl = '/';

    public function routes(Closure $routes): static
    {
        $this->routes[] = $routes;
        return $this;
    }

    public function authenticatedRoutes(Closure $routes): static
    {
        $this->authenticatedRoutes[] = $routes;
        return $this;
    }

    public function middleware($middleware): static
    {
        $middleware       = is_array($middleware) ? $middleware : [$middleware];
        $this->middleware = [
            ...$this->middleware,
            ...$middleware,
        ];

        return $this;
    }

    public function authMiddleware($middleware): static
    {
        $middleware           = is_array($middleware) ? $middleware : [$middleware];
        $this->authMiddleware = [
            ...$this->authMiddleware,
            ...$middleware,
        ];

        return $this;
    }

    public function getMiddleware(): array
    {
        return [
            SetCurrentAdmin::class . ":{$this->getId()}",
            ...config('merlion.admin.route.middlewares'),
            ...$this->middleware,
        ];
    }

    public function getAuthMiddleware(): array
    {
        return [
            ...config('merlion.admin.route.auth_middlewares'),
            ...$this->authMiddleware,
        ];
    }

    public function getRoute(string $name, ...$args): string
    {
        if (Str::isUrl($name)) {
            return $name;
        }

        $route_name = $name;

        $as = $this->getId() . '.';

        if (!Str::startsWith($route_name, $as)) {
            $route_name = $as . $route_name;
        }

        return route($route_name, ...$args);
    }

    public function routeExists(string $name): bool
    {
        $route_name = $name;

        $as = $this->getContext('route.as');

        if (!Str::startsWith($route_name, $as)) {
            $route_name = $as . $route_name;
        }

        return Route::has($route_name);
    }

//    public function bootApiRoutes(): void
//    {
//        if (config('merlion.admin.api_routes_enabled')) {
//            require __DIR__ . '/../../../../routes/api.php';
//        }
//    }
}
