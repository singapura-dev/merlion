<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

use Merlion\Components\Concerns\AsInput;

class Text extends Filter
{
    use AsInput;

    protected string $view = 'merlion::table.filters.text';

}
