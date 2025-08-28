<?php
declare(strict_types=1);

namespace Merlion\Components\Show\Grid;

use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\AsText;
use Merlion\Components\Concerns\Copyable;

class Text extends Grid
{
    use Copyable;
    use AsLink;
    use AsText;
}
