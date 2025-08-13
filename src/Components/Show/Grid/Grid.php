<?php
declare(strict_types=1);

namespace Merlion\Components\Show\Grid;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Schema;

abstract class Grid extends Schema
{
    use HasModel;
    use AsCell;

    public static array $grids = [
        'text' => Text::class,
        'image' => Image::class,
        'select' => Select::class,
    ];

    public static function generate($grid): static
    {
        if (is_string($grid)) {
            $grid = [
                'name' => $grid,
                'type' => 'text',
            ];
        }

        if (is_array($grid)) {
            $grid_class = static::$grids[$grid['type'] ?? 'text'] ?? Text::class;
            unset($grid['type']);
            $grid = $grid_class::make($grid);
        }

        if ($grid instanceof Grid) {
            return $grid;
        }
    }
}
