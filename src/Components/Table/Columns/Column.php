<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Exception;
use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Schema;

/**
 * @method bool getSortable()
 * @method bool getFilterable()
 */
class Column extends Schema
{
    use HasModel;
    use AsCell;

    public mixed $filterable = false;
    public mixed $sortable = false;

    public static array $columns = [
        'text'   => Text::class,
        'select' => Select::class,
        'image'  => Image::class,
        'toggle' => Toggle::class,
    ];

    public function filterable($filterable = true): static
    {
        $this->filterable = $filterable;
        return $this;
    }

    public function sortable($sortable = true): static
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function getSortUrl(): string
    {
        $current_sort = request('sort');
        $sort         = $this->getName();

        if ($current_sort === $sort) {
            $sort = '-' . $this->getName();
        }
        return request()->fullUrlWithQuery(['sort' => $sort]);
    }

    public function getSortIcon(): string
    {
        $current_sort = request('sort');
        $sort         = $this->getName();

        if ($current_sort === $sort) {
            return 'ti ti-sort-ascending';
        }

        if ($current_sort === '-' . $sort) {
            return 'ti ti-sort-descending';
        }

        return 'ti ti-arrows-sort';
    }

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

}
