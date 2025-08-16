<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Closure;

trait Copyable
{
    protected bool $copyable = false;
    protected Closure $getCopyableValueUsing;

    public function renderCopyable(): void
    {
        if ($this->copyable) {
            $this->withAttributes([
                'data-copyable' => $this->getCopyableValue()
            ]);
        }
    }

    protected function getCopyableValue(): string
    {
        if (!empty($this->getCopyableValueUsing)) {
            return call_user_func($this->getCopyableValueUsing, $this);
        }

        return to_string($this->getValue());
    }

    public function copyable(bool|Closure $copyable = true): static
    {
        if (is_bool($copyable)) {
            $this->copyable = $copyable;
        }

        if (is_callable($copyable)) {
            $this->copyable = true;
            $this->getCopyableValueUsing = $copyable;
        }

        return $this;
    }
}
