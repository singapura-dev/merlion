<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Merlion\Components\Icon;

trait HasIcon
{
    protected mixed $icon = null;

    public function icon(mixed $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function getIcon(): ?Icon
    {
        if (empty($this->icon)) {
            return null;
        }
        return Icon::generate($this->evaluate($this->icon));
    }
}
