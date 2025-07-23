<?php

declare(strict_types=1);

namespace Merlion\Components;

class Alert extends Renderable
{
    public string $type = 'success';
    public string $title = '';

    protected string $view = 'merlion::alert';
}
