<?php

declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;

/**
 * Table
 *
 * @method $this rows(mixed $rows) Set rows
 * @method $this actions(mixed $actions) Set actions
 */
class Table extends Renderable
{
    protected string $view = 'merlion::table.table';

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
}
