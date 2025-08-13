<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

/**
 * @method $this placeholder(string|Closure $placeholder) Set place holder
 * @method $this inputType(string|Closure $inputType) Set input type
 */
trait AsInput
{
    public mixed $placeholder = '';
    public mixed $inputType = 'text';
    public mixed $labelPosition = 'default';
    public mixed $required = false;

    public function required($required = true): static
    {
        $this->required = $required;
        return $this;
    }

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

    public function password(): static
    {
        $this->inputType = 'password';
        return $this;
    }

    public function date(): static
    {
        $this->inputType = 'date';
        return $this;
    }

    public function email(): static
    {
        $this->inputType = 'email';
        return $this;
    }

    public function dateTime(): static
    {
        $this->inputType = 'datetime-local';
        return $this;
    }
}
