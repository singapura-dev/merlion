<?php


declare(strict_types=1);

namespace Merlion\Components\Modal;

use Closure;
use Merlion\Components\Button;
use Merlion\Components\Concerns\AsContainer;
use Merlion\Components\Renderable;

class Modal extends Renderable
{
    use AsContainer;

    public $view = 'merlion::modal.modal';

    public mixed $button;

    public string $mode = 'modal';        // modal | offcanvas
    public string $position = 'start';    // start | end | top | bottom
    public ?string $size = null;          // sm | lg | xl | fullscreen
    public string|null|Closure $label = null;
    public string|null|Closure $title = null;

    public function offcanvas($position = 'start'): static
    {
        $this->mode     = 'offcanvas';
        $this->position = $position;
        return $this;
    }

    public function button($button): static
    {
        if (is_string($button)) {
            $button = Button::make($button);
        }

        if (is_callable($button)) {
            $_button = Button::make();
            call_user_func($button, $_button);
            $button = $_button;
        }

        $this->button = $button;

        return $this;
    }

    public function getButton(): Button
    {
        return $this->button;
    }

}
