<?php

namespace Merlion\Components\Concerns\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait HasRoutes
{
    public function getRoute(string $name, ...$args): string
    {
        if (Str::isUrl($name)) {
            return $name;
        }

        $route_name = $name;

        $as = $this->getContext('route.as');

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
}
