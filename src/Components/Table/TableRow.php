<?php
declare(strict_types=1);

namespace Merlion\Components\Table;

use use use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Renderable;
use Merlion\Components\Table\Columns\Column;

/**
 * @method $this table(Table $table) Set table
 */
class TableRow extends Renderable
{
    use HasModel;

    public ?Table $table = null;
    public array $columns = [];

    public function getColumns(): array
    {
        $columns = [];
        foreach ($this->table->getColumns() as $column) {
            /** @var Column $column */
            $column = deep_clone($column);
            $columns[] = $column->model($this->getModel());
        }
        return $columns;
    }
}
