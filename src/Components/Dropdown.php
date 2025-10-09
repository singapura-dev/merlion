<?php

declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;
class Dropdown extends Renderable
{
    use HasIcon;
    use HasContent;
}
