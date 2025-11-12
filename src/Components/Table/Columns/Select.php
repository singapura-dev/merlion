<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\AsSelectDisplayer;

class Select extends Text
{
    use AsSelectDisplayer;
}
