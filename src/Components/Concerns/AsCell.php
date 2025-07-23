<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method string|null getLabel() Get field label
 * @method string|null getName() Get field name
 * @method mixed getValue() Get field value
 */
trait AsCell
{
    public string|Closure|null $name = null;
    public string|Closure|null $label = null;
    public mixed $value = null;

    public function __construct(...$args)
    {
        if (!empty($args[0])) {
            $this->name = $args[0];
        }

        if (!empty($args[1])) {
            $this->label = $args[1];
        }
    }

    public function label(mixed $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function name(mixed $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function value(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }
}
