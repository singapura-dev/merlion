<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method $this label(string|Closure $label) Set field label
 * @method $this name(string|Closure $name) Set field name
 * @method $this value(string|Closure $value) Set field value
 * @method string|null getLabel() Get field label
 * @method string|null getName() Get field name
 * @method mixed getValue() Get field value
 */
trait AsCell
{
    public string|Closure|null $name = null;
    public string|Closure|null $label = null;
    public mixed $value = null;
}
