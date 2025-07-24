<?php

declare(strict_types=1);

namespace Merlion\Components;

use Closure;

/**
 * @method $this icon(string|Closure $icon) Set icon
 * @method $this image(string|Closure $image) Set image
 * @method $this svg(string|Closure $svg) Set svg
 */
class Icon extends Renderable
{
    protected string $view = 'merlion::icon';
    public mixed $icon = ''; // webfont
    public mixed $svg = '';
    public mixed $image = '';
}
