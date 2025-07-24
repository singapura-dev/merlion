<?php

declare(strict_types=1);

namespace Merlion\Components\Pages\Crud;

use Closure;
use Merlion\Components\Button;
use Merlion\Components\Concerns\HasModel;

/**
 * @method $this route(string|Closure $route) Set route
 * @method string getRoute() Get route
 */
class RowActionButton extends Button
{
    use HasModel;

    public string $route = '';

    public function setupRowActionButton(...$args): void
    {
        $this->xs();
    }
}
