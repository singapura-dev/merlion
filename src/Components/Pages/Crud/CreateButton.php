<?php

declare(strict_types=1);

namespace Merlion\Components\Pages\Crud;

use Closure;
use Merlion\Components\Button;

/**
 * @method $this route(string|Closure $route) Set route
 * @method string getRoute() Get route
 */
class CreateButton extends Button
{
    public mixed $route = '';

    public function setupCreateButton(...$args): void
    {
        $this->primary()
            ->label(__('merlion::base.create'))
            ->icon('ri-add-line me-2');
    }

    public function renderCreateButton(): void
    {
        $this->link(admin()->route($this->getRoute() . '.create'));
    }
}
