<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;
use Merlion\Components\Icon;

/**
 * @method $this icon(string|Closure|Icon $icon) Set icon
 */
trait HasIcon
{
    public mixed $icon = '';
    public string $iconPosition = 'before'; // before|after

    public function iconBefore(): static
    {
        $this->iconPosition = 'before';
        return $this;
    }

    public function iconAfter(): static
    {
        $this->iconPosition = 'after';
        return $this;
    }

    public function getIcon(): mixed
    {
        if (is_string($this->icon)) {
            $this->icon = Icon::make(icon: $this->icon);
        }
        return $this->evaluate($this->icon);
    }
}
