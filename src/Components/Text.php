<?php

declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;

class Text extends Renderable
{
    use HasContent;
    use AsLink;
    use HasIcon;
}
