<?php

declare(strict_types=1);

namespace Merlion\Components\Containers;

class Flex extends Container
{
    public function registerFlex(): void
    {
        $this->class('d-flex');
    }

    public function wrap(): static
    {
        return $this->class('flex-wrap');
    }

    public function gap($gap = 1): static
    {
        return $this->class('gap-' . $gap);
    }

    public function column(): static
    {
        return $this->class('flex-column');
    }

    public function alignItems($position): static
    {
        return $this->class('align-items-' . $position);
    }
}
