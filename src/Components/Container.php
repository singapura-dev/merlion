<?php

declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsContainer;

/**
 * @method $this setWrapper($wrapper) set container wrapper, like div, span etc
 */
class Container extends Renderable
{
    use AsContainer;

    public string $wrapper = 'div';
    protected string $view = 'merlion::container';

    public function __construct(...$content)
    {
        $this->content(...$content);
    }

}
