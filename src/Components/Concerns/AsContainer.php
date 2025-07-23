<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsContainer
{
    protected array $_children = [];

    public function content(...$args): static
    {
        foreach ($args as $arg) {
            if (is_array($arg)) {
                array_push($this->_children, ...$arg);
            } else {
                if (!empty($arg)) {
                    $this->_children [] = $arg;
                }
            }
        }
        return $this;
    }

    public function getContent(): array
    {
        return $this->_children;
    }
}
