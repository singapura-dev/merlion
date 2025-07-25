<?php

declare(strict_types=1);

namespace Merlion\Components;

class Flex extends Container
{

    public function setupFlex(...$args): static
    {
        return $this->class('d-flex');
    }

    public function wrap(): static
    {
        return $this->class('flex-wrap');
    }

    public function column(): static
    {
        return $this->class('flex-column');
    }

    public function justifyContent($position = 'start'): static
    {
        return $this->class('justify-content-' . $position);
    }

    public function alignItems($position = 'start'): static
    {
        return $this->class('align-items-' . $position);
    }

    public function alignContent($position = 'start'): static
    {
        return $this->class('align-content-' . $position);
    }

    public function gap($size = '1'): static
    {
        return $this->class('gap-' . $size);
    }

    public function gapX($size = '1'): static
    {
        return $this->class('gap-x-' . $size);
    }

    public function gapY($size = '1'): static
    {
        return $this->class('gap-y-' . $size);
    }

    public function gapInline($size = '1'): static
    {
        return $this->class('gap-inline-' . $size);
    }
}
