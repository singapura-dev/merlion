<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;

/**
 * @method string getName()
 */
class Sort extends Renderable
{
    use AsCell;

    public string $field = '';

    public bool $default = false;

    public function selected(): bool
    {
        return request('sort') == $this->getName();
    }

    public function default($defualt = true): static
    {
        $this->default = $defualt;
        return $this;
    }
}
