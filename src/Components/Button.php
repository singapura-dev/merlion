<?php

declare(strict_types=1);

namespace Merlion\Components;

/**
 * @method $this label(mixed $label) Set label
 * @method $this icon(mixed $icon) Set icon
 */
class Button extends Renderable
{
    protected string $view = 'merlion::button';

    public string $wrapper = 'button';

    public mixed $label = '';
    public mixed $icon = '';
    public string $iconPosition = 'start'; // start|end

    public function setupButton(...$args): void
    {
        $this->class('btn');
    }

    public function iconStart(): static
    {
        $this->iconPosition = 'start';
        return $this;
    }

    public function iconEnd(): static
    {
        $this->iconPosition = 'end';
        return $this;
    }

    public function submit(): static
    {
        return $this->withAttributes(['type' => 'submit']);
    }

    public function reset(): static
    {
        return $this->withAttributes(['type' => 'reset']);
    }

    public function primary(): static
    {
        return $this->class('btn-primary');
    }

    public function ghost($color = 'primary'): static
    {
        return $this->class('btn-ghost-' . $color);
    }

    public function soft($color = 'primary'): static
    {
        return $this->class('btn-soft-' . $color);
    }

    public function outline(): static
    {
        return $this->class('btn-outline');
    }

    public function pill(): static
    {
        return $this->class('btn-pill');
    }

    public function xs(): static
    {
        return $this->class('btn-xs');
    }

    public function sm(): static
    {
        return $this->class('btn-sm');
    }

    public function md(): static
    {
        return $this->class('btn-md');
    }

    public function lg(): static
    {
        return $this->class('btn-lg');
    }

    public function xl(): static
    {
        return $this->class('btn-xl');
    }

    public function plain(): static
    {
        return $this->removeClass('btn');
    }

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
        $this->withAttributes(['href' => $link, 'target' => $target]);
        return $this;
    }

    public function renderButton(): void
    {
        if (is_string($this->icon)) {
            $this->icon = Icon::make(icon: $this->icon);
        }
    }
}
