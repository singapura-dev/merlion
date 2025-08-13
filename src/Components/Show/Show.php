<?php
declare(strict_types=1);

namespace Merlion\Components\Show;

use Merlion\Components\Concerns\HasContent;
use Merlion\Components\Concerns\HasModel;
use Merlion\Components\Renderable;
use Merlion\Components\Show\Grid\Grid;

class Show extends Renderable
{
    use HasContent;
    use HasModel;

    public function grid($grid): static
    {
        $grid = Grid::generate($grid);
        $this->content($grid);
        return $this;
    }
}
