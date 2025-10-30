<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait HasSize
{
    public mixed $size = null;
    public mixed $width = null;
    public mixed $height = null;

    public function getHeight()
    {
        if (empty($this->height)) {
            return $this->evaluate($this->size);
        }

        return $this->evaluate($this->height);
    }

    public function getWidth()
    {
        if (empty($this->width)) {
            return $this->evaluate($this->size);
        }

        return $this->evaluate($this->width);
    }
}
