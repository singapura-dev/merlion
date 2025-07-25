<?php

declare(strict_types=1);

namespace Merlion\Components\Infolist\Entry;

class Text extends Entry
{
    protected string $view = 'merlion::gird.displayers.text';
    public mixed $status = null;
}
