<?php

namespace Merlion\Components;

class View extends Renderable
{
    public function __construct(string $view)
    {
        $this->view = $view;
    }
}
