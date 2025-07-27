<?php

declare(strict_types=1);

namespace Merlion\Components\Container;

use Merlion\Components\Concerns\AsFlex;

class Flex extends Container
{
    use AsFlex;

    public function setupFlex(...$args): static
    {
        return $this->flex();
    }
}
