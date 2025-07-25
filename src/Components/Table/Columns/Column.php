<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Renderable;

/**
 * Column
 */
abstract class Column extends Renderable
{
    use AsCell;
    use HasModel;

    public bool $sortable = false;

    public static array $columnsMap = [
        'text' => Text::class,
    ];

    public static function generate(string $type, ...$args): Column
    {
        return static::$columnsMap[$type]::make(...$args);
    }

    public function sortable($sortable = true): static
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function getValue()
    {
        if (!empty($this->value)) {
            return evaluate($this->value, $this);
        }
        return data_get($this->getModel(), $this->name);
    }
}
