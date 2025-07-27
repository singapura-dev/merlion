<?php

declare(strict_types=1);

namespace Merlion\Components\Container;

use Merlion\Components\Concerns\AsContainer;
use Merlion\Components\Renderable;

/**
 * @method $this setWrapper($wrapper) set container wrapper, like div, span etc
 */
class Container extends Renderable
{
    use AsContainer;

    public string $wrapper = 'div';
    public $view = 'merlion::container';
}
