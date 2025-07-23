<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method $this placeholder(string|Closure $placeholder) Set place holder
 */
trait AsInput
{
    public mixed $placeholder = '';
    public mixed $inputType = 'text';
    public mixed $labelPosition = 'default';

    public function labelInline(): static
    {
        $this->labelPosition = 'inline';
        return $this;
    }

    public function labelHorizontal(): static
    {
        $this->labelPosition = 'horizontal';
        return $this;
    }

    public function date()
    {
        $this->inputType = 'date';
        return $this;
    }

    public function dateTime()
    {
        $this->inputType = 'datetime-local';
        return $this;
    }
}
