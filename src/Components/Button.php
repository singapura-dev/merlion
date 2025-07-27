<?php

declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsButton;
use Merlion\Components\Concerns\HasIcon;

/**
 * @method $this label(mixed $label) Set label
 * @method $this icon(mixed $icon) Set icon
 */
class Button extends Renderable
{
    use AsButton;
    use HasIcon;

    public $view = 'merlion::button';

    public string $wrapper = 'button';

    public mixed $label = '';

    public function action($action, $method = 'post'): static
    {
        return $this->withAttributes(['data-action' => $action, 'data-method' => $method]);
    }

    public function confirm($title): static
    {
        return $this->withAttributes(['data-confirm' => $title]);
    }

    public function link($link, $target = '_self'): static
    {
        $this->wrapper = 'a';
        return $this->withAttributes(['href' => $link, 'target' => $target]);
    }

}
