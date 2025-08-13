<?php

namespace Merlion\Components\Containers;

use Closure;
use Merlion\Components\Renderable;

/**
 * @method $this renderable(string|Closure $renderable) Set renderable
 * @method string getRenderable() Get context
 */
class Lazy extends Renderable
{
    public mixed $renderable = '';
}
