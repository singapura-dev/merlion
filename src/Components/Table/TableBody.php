<?php
declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Renderable;

/**
 * @method $this table(Table $table) Set table
 */
class TableBody extends Renderable
{
    public Table $table;

    public function getRows(): array
    {
        if (empty($this->table)) {
            return [];
        }
        $rows = [];

        $table = $this->table;
        $index = 0;
        foreach ($table->models as $model) {
            $row = TableRow::make()->table($this->table)->model($model);
            if (!empty($callback = $table->getRendingRow())) {
                call_user_func($callback, $row, $index);
            }
            $rows[] = $row;
            $index++;
        }
        return $rows;
    }
}
