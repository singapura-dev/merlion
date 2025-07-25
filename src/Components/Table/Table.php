<?php

declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Column;

/**
 * Table
 *
 * @method $this rows(mixed $rows) Set rows
 * @method $this actions(mixed $actions) Set actions
 */
class Table extends Renderable
{
    public $view = 'merlion::table.table';

    public array $columns = [];
    public array $actions = [];
    public array $tools = [];
    public mixed $rows = [];

    public bool $selectable = false;

    public function selectable(): static
    {
        $this->selectable = true;
        $this->class('table-selectable');
        return $this;
    }

    public function columns($columns): static
    {
        $columns = is_array($columns) ? $columns : func_get_args();
        array_push($this->columns, ...$columns);
        return $this;
    }

    public function getColumns(): array
    {
        $columns = [];
        foreach ($this->columns as $column) {
            if (is_string($column)) {
                $column = [
                    'type' => 'text',
                    'name' => $column,
                ];
            }

            if (is_array($column)) {
                $column = Column::generate($column['type'] ?? 'text', $column);
            }

            if ($column instanceof Column) {
                $columns[] = $column;
            }
        }
        return $columns;
    }

    public function actions($actions): static
    {
        $actions = is_array($actions) ? $actions : func_get_args();
        array_push($this->actions, ...$actions);
        return $this;
    }
}
