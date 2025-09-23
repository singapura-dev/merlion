<?php

declare(strict_types=1);

namespace Merlion\Components\Table;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Renderable;

/**
 * @method $this table($table) Set table
 * @method Table getTable() get table
 */
class BatchActions extends Renderable
{
    use HasIcon;
    use AsCell;
    use HasContent;

    public Table $table;

    public function actions($actions): static
    {
        $this->content($actions);
        return $this;
    }

    public function getActions(): array
    {
        return $this->getContent();
    }
}
