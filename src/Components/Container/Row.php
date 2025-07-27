<?php

declare(strict_types=1);

namespace Merlion\Components\Container;

use Merlion\Components\Concerns\AsRow;

class Row extends Container
{
    use AsRow;

    public function setupRow(...$args): static
    {
        return $this->row();
    }

    public function row($class = 'row'): static
    {
        return $this->class($class);
    }

    public function gap($gap = 3): static
    {
        return $this->class('g-' . $gap);
    }

    public function column($content, $class = 'col'): Container
    {
        $container = Container::make()->class($class);
        $container->content($content);
        $this->content($container);
        return $container;
    }
}
