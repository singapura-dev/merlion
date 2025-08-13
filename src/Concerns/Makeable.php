<?php
declare(strict_types=1);

namespace Merlion\Concerns;

trait Makeable
{
    public static function make(...$parameters): static
    {
        return new static(...$parameters);
    }
}
