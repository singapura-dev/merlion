<?php
declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Column;

/**
 * @method array getColumns() Get table columns
 * @method $this models(mixed $models) Set table data
 * @method $this selectable(mixed $selectable) Set table selectable
 * @method bool getSelectable() Get table selectable
 */
class Table extends Renderable
{
    public mixed $columns = [];
    public mixed $models = [];
    public TableHeader $header;
    public TableBody $body;
    public mixed $selectable = false;

    protected mixed $rendingRowUsing = null;

    public function __construct(...$args)
    {
        parent::__construct($args);

        $first = $args[0] ?? null;
        if (is_array($first) && $first[0] instanceof Column) {
            $this->columns($first);
        }
    }

    public function columns($columns): static
    {
        foreach ($columns as $column) {
            $this->column($column);
        }
        return $this;
    }

    public function column($column): Column
    {
        $column = Column::generate($column);
        $this->columns[] = $column;
        return $column;
    }

    public function registerTable(): void
    {
        $this->header = TableHeader::make()->table($this);
        $this->body = TableBody::make()->table($this);
    }

    public function rendingRow($callback): static
    {
        $this->rendingRowUsing = $callback;
        return $this;
    }

    public function getRendingRow(): ?callable
    {
        return $this->rendingRowUsing ?? null;
    }

    public function body($callback): static
    {
        call_user_func($callback, $this->body);
        return $this;
    }

    public function header($callback): static
    {
        call_user_func($callback, $this->header);
        return $this;
    }
}
