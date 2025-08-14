<?php
declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasIcon;

/**
 * @method $this priority(int $priority) Set priority
 */
class Menu extends Renderable
{
    use AsCell;
    use AsLink;
    use HasContent;
    use HasIcon;

    public bool $divider = false;
    public int $priority = 1;

    public function divider($divider = true): static
    {
        $this->divider = $divider;
        return $this;
    }

    public function isDivider(): bool
    {
        return $this->divider ?? false;
    }
}
