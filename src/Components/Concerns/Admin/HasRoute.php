<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns\Admin;

use Illuminate\Support\Str;

trait HasRoute
{
    public function route($name, ...$args)
    {
        if (Str::isUrl($name)) {
            return $name;
        }

        $route_name = $name;

        if (!Str::startsWith($name, config('merlion.route.as'))) {
            $route_name = config('merlion.route.as') . $name;
        }

        return route($route_name, ...$args);
    }
}
