<?php

declare(strict_types=1);

namespace Merlion\Components;

class Display extends Renderable
{
    public function __construct(
        public mixed $display = null
    ) {
    }

    public function render()
    {
        return render($this->display);
    }
}
