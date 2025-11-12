<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\HasSize;

class Image extends Column
{
    use HasSize;

    public mixed $multiple = false;
}
