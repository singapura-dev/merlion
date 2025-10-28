<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns\Admin;

trait Defaultable
{
    protected bool $_default = false;

    public function default(bool $default = true): static
    {
        $this->_default = $default;
        return $this;
    }

    public function isDefault(): bool
    {
        return $this->_default;
    }
}
