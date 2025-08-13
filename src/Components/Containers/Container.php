<?php

declare(strict_types=1);

namespace Merlion\Components\Containers;

use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Renderable;

class Container extends Renderable
{
    use HasContent;

    public string $element = 'div';

    public function __construct(...$args)
    {
        $first = $args[0] ?? null;
        if (is_array($first) || $first instanceof Renderable) {
            $this->content($first);
        }
        parent::__construct(...$args);
    }

    public function span(): static
    {
        return $this->element('span');
    }

    public function element($element): static
    {
        $this->element = $element;
        return $this;
    }

    public function template(): static
    {
        return $this->element('template');
    }
}
