<?php
declare(strict_types=1);

namespace Merlion\Components;

/**
 * @method $this position($position)
 */
class Icon extends Renderable
{
    public mixed $position = 'start';

    public static function generate($icon): static
    {
        if (is_string($icon)) {
            $icon = [
                'class' => $icon
            ];
        }

        if (is_array($icon)) {
            $icon = Icon::make($icon);
        }

        if (is_callable($icon)) {
            $icon = Icon::make()->rendering($icon);
        }

        return $icon;
    }
}
