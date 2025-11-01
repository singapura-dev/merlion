<?php

declare(strict_types=1);

namespace Merlion\Components\Widgets;

use Merlion\Components\Renderable;

/**
 * @method $this|static length($length)
 * @method $this|static gap($gap)
 * @method $this|static size($size)
 */
class OtpInput extends Renderable
{
    public mixed $length = 6;
    public mixed $name = 'otp';
    public mixed $type = 'number';
    public mixed $gap = 3;
    public mixed $size = null;

    public function text(): static
    {
        $this->type = 'text';
        return $this;
    }

    public function small(): static
    {
        $this->size = 'sm';
        return $this;
    }

    public function large(): static
    {
        $this->size = 'lg';
        return $this;
    }
}
