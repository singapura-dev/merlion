<?php
declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;

class Menu extends Renderable
{
    use AsCell;
    use AsLink;
    use HasContent;
    use HasIcon;

    public mixed $divider = null;

    public function divider($divider = true): static
    {
        $this->divider = $divider;
        return $this;
    }
}
