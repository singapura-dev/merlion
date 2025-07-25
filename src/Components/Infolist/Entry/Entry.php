<?php

declare(strict_types=1);

namespace Merlion\Components\Infolist\Entry;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Infolist\Infolist;
use Merlion\Components\Renderable;

/**
 * Entry
 */
abstract class Entry extends Renderable
{
    use AsCell;

    public mixed $model = null;
    public ?Infolist $infolist = null;
    public bool $full = false;

    public static array $itemsMap = [
        'text' => Text::class,
    ];

    public static function generate($type, ...$args)
    {
        return static::$itemsMap[$type]::make(...$args);
    }

    public function getValue()
    {
        if (!empty($this->value)) {
            return evaluate($this->value, $this);
        }
        return data_get($this->model ?? $this->infolist?->model, $this->name);
    }
}
