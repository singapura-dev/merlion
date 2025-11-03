<?php

namespace Merlion\Components\Concerns\Admin;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\Serializers\Native;
use Merlion\Http\Middleware\Authenticate;
use Merlion\Http\Middleware\SetCurrentAdmin;

/**
 * @method $this|static path($path) Set prefix
 * @method $this|static home($home) Set home controller
 * @method array getDomains()
 * @method array getAuthenticatedRoutes()
 * @method array getRoutes()
 * @method string getPath()
 * @method string getHome()
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

    public mixed $domains = [];

    public mixed $home = null;
    public mixed $homeUrl = '/';

    public function routes(Closure|string $routes): static
    {
        $this->routes[] = $routes;
        return $this;
    }

    public function authenticatedRoutes(Closure|string $routes): static
    {
        $this->authenticatedRoutes[] = $routes;
        return $this;
    }

    public function domains($domain): static
    {
        $domains       = is_array($domain) ? $domain : [$domain];
        $this->domains = [
            ...$this->domains,
            ...$domains,
        ];
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
            ...config('merlion.admin.route.middlewares'),
            ...$this->middleware,
            SetCurrentAdmin::class . ":{$this->getId()}",
        ];
    }

    public function getAuthMiddleware(): array
    {
        return [
            Authenticate::class . ':' . $this->getId(),
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

    public function getHomeUrl()
    {
        if (empty($this->homeUrl)) {
            return $this->getRoute('home');
        }

        if (is_callable($this->homeUrl)) {
            $this->homeUrl = $this->evaluate($this->homeUrl);
        }

        if (Str::isUrl($this->homeUrl)) {
            return $this->homeUrl;
        }

        if (Str::startsWith($this->homeUrl, '/')) {
            return $this->homeUrl;
        }

        return '/' . $this->path . '/' . $this->homeUrl;
    }
}
