<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Merlion\Components\Container;

class Flex extends Container
{

    public function setupFlex()
    {
        return $this->class('d-flex');
    }

    public function wrap()
    {
        return $this->class('flex-wrap');
    }

    public function column()
    {
        return $this->class('flex-column');
    }

    public function justifyContent($position = 'start')
    {
        return $this->class('justify-content-' . $position);
    }

    public function alignItems($position = 'start')
    {
        return $this->class('align-items-' . $position);
    }

    public function alignContent($position = 'start')
    {
        return $this->class('align-content-' . $position);
    }

    public function gap($size = '1')
    {
        return $this->class('gap-' . $size);
    }

    public function gapX($size = '1')
    {
        return $this->class('gap-x-' . $size);
    }

    public function gapY($size = '1')
    {
        return $this->class('gap-y-' . $size);
    }

    public function gapInline($size = '1')
    {
        return $this->class('gap-inline-' . $size);
    }
}
