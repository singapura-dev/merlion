<?php
declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Column;

/**
 * @method array getColumns() Get table columns
 * @method $this models(mixed $models) Set table data
 * @method $this paginate($perPage) Set models per page
 * @method $this multiple($multiple) Set table multiple selectable
 * @method $this selectable($selectable) Set table selectable
 * @method $this crossPageSelection($selectable) Set table cross-page selectable
 * @method bool getSelectable() Get table selectable
 */
class Table extends Renderable
{
    public mixed $columns = [];
    public mixed $models = [];
    public TableHeader $header;
    public TableBody $body;
    public mixed $selectable = false;
    public mixed $multiple = true;
    public mixed $paginate = null;
    public mixed $crossPageSelection = false;

    protected mixed $rendingRowUsing = null;

    public function __construct(...$args)
    {
        parent::__construct($args);

        $first = $args[0] ?? null;
        if (is_array($first) && $first[0] instanceof Column) {
            $this->columns($first);
        }
    }

    public function getModels()
    {
        if (is_string($this->models)) {
            $models = app($this->models);
            if ($this->paginate) {
                return $models->paginate($this->paginate);
            }
            return $models->get();
        }
        return $this->evaluate($this->models);
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
        return $this->rendingRowUsing;
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
