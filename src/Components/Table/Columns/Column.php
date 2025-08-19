<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Exception;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Schema;

class Column extends Schema
{
    use HasModel;
    use AsCell;

    public static array $columns = [
        'text' => Text::class,
        'select' => Select::class,
        'image' => Image::class,
    ];

    public static function generate($column): static
    {
        if (is_string($column)) {
            $column = [
                'name' => $column,
                'type' => 'text',
            ];
        }

        if (is_array($column)) {
            $column_class = static::$columns[$column['type'] ?? 'text'] ?? Text::class;
            unset($column['type']);
            $column = $column_class::make($column);
        }

        if ($column instanceof Column) {
            return $column;
        }

        throw new Exception('Invalid column');
    }

    public function diaplayValue()
    {
        return $this->getValue();
    }

}
