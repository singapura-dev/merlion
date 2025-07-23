<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Closure;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Renderable;

/**
 * Column
 *
 * @method $this setName(string|Closure $name) Set name
 * @method $this setLabel(string|Closure $label) Set label
 */
abstract class Column extends Renderable
{
    use AsCell;

    public mixed $row = null;

    public bool $sortable = false;

    public function sortable($sortable = true): static
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function getValue()
    {
        if (!empty($this->value)) {
            return evaluate($this->value, $this);
        }
        return data_get($this->row, $this->name);
    }
}
