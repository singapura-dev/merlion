<?php


declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Container\Container;

class Text extends Container
{
    public function h1(): static
    {
        return $this->wrapper('h1');
    }

    public function h2(): static
    {
        return $this->wrapper('h2');
    }

    public function h3(): static
    {
        return $this->wrapper('h3');
    }

    public function h4(): static
    {
        return $this->wrapper('h4');
    }

    public function h5(): static
    {
        return $this->wrapper('h5');
    }

    public function span(): static
    {
        return $this->wrapper('span');
    }

    public function small()
    {
        return $this->wrapper('small');
    }

    public function p(): static
    {
        return $this->wrapper('p');
    }

    public function strong(): static
    {
        return $this->wrapper('strong');
    }
}
