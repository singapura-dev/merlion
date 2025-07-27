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

    public function column($content)
    {
    }
}
