<?php


declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\HasLink;
use Merlion\Components\Container\Container;

class Text extends Container
{
    use HasLink;

    public mixed $wrapper = 'span';

    public function renderText(): void
    {
        if (!empty($this->link)) {
            $this->a();
            $this->withAttributes(['href' => $this->getLink(), 'target' => $this->getTarget()]);
        }
    }

    public function h1(): static
    {
        return $this->class('h1');
    }

    public function h2(): static
    {
        return $this->class('h2');
    }

    public function h3(): static
    {
        return $this->class('h3');
    }

    public function h4(): static
    {
        return $this->class('h4');
    }

    public function h5(): static
    {
        return $this->class('h5');
    }

    public function a(): static
    {
        return $this->wrapper('a');
    }

    public function small(): static
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
