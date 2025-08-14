<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\Copyable;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasModal;

class Text extends Column
{
    use Copyable;
    use AsLink;
    use HasIcon;
    use HasModal;
}
