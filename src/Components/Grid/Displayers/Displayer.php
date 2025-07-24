<?php

declare(strict_types=1);

namespace Merlion\Components\Grid\Displayers;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Grid\Grid;
use Merlion\Components\Renderable;

/**
 * Grid
 */
abstract class Displayer extends Renderable
{
    use AsCell;

    public mixed $model = null;
    public ?Grid $grid = null;
    public bool $full = false;

    public static array $displayersMap = [
        'text' => Text::class,
    ];

    public static function displayer($type, ...$args)
    {
        return static::$displayersMap[$type]::make(...$args);
    }

    public function getValue()
    {
        if (!empty($this->value)) {
            return evaluate($this->value, $this);
        }
        return data_get($this->model ?? $this->grid?->model, $this->name);
    }
}
