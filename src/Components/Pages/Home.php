<?php

declare(strict_types=1);

namespace Merlion\Components\Pages;

use Merlion\Components\Concerns\HasStaticCallbacks;
use Merlion\Components\Container;

class Home extends Container
{
    use HasStaticCallbacks;

    public static string $title = 'Home';
}
