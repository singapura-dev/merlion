<?php
declare(strict_types=1);

namespace Merlion\Components\Table;

use use use Merlion\Components\Renderable;

/**
 * @method $this table(Table $table) Set table
 */
class TableHeader extends Renderable
{
    public Table $table;
}
