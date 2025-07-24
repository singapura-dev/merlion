<?php

namespace Merlion\Components;

use Closure;

/**
 * @method $this label(string|Closure $label) Set menu label
 * @method $this link(string|Closure $link) Set menu link
 * @method $this icon(string|Closure $icon) Set menu icon
 * @method $this target(string|Closure $target) Set menu target
 * @method $this title(bool|Closure $title) Set menu title
 */
class Menu extends Renderable
{
    protected string $view = 'merlion::menu';

    public string|Closure|null $label = null;
    public string|Closure|null $link = null;
    public mixed $icon = null;
    public string|Closure|null $target = null;
    public bool|Closure|null $title = false;

    public function renderMenu(): void
    {
        if (empty($this->icon)) {
            return;
        }
        if (is_string($this->icon)) {
            $this->icon = Icon::make(icon: $this->icon);
        }
    }
}
