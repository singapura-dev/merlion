<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsRow
{
    public function row(): static
    {
        return $this->class('row');
    }

}
