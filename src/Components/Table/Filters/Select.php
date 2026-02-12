<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

/**
 * @method static options($options)
 */
class Select extends Text
{
    public bool $multiple = false;
    public mixed $options = [];

    public function multiple(bool $value = true): static
    {
        $this->multiple = $value;
        return $this;
    }
}
