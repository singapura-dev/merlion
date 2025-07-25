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
    public bool $plain = false;
    public string $iconPosition = 'before'; // before|after

    public function iconBefore(): static
    {
        $this->iconPosition = 'before';
        return $this;
    }

    public function iconAfter(): static
    {
        $this->iconPosition = 'after';
        return $this;
    }

    public function text($color): static
    {
        return $this->class('text-' . $color);
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

    public function danger(): static
    {
        return $this->class('btn-danger');
    }

    public function warning(): static
    {
        return $this->class('btn-warning');
    }

    public function info(): static
    {
        return $this->class('btn-info');
    }

    public function ghost(): static
    {
        return $this->class('btn-ghost');
    }

    public function soft(): static
    {
        return $this->class('btn-soft');
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

    public function action($action, $method = 'post'): static
    {
        return $this->withAttributes(['data-action' => $action, 'data-method' => $method]);
    }

    public function confirm($title): static
    {
        return $this->withAttributes(['data-confirm' => $title]);
    }

    public function plain($plain = true): static
    {
        $this->wrapper = 'a';
        $this->plain   = $plain;
        return $this;
    }

    public function link($link, $target = '_self'): static
    {
        $this->wrapper = 'a';
        return $this->withAttributes(['href' => $link, 'target' => $target]);
    }

    public function renderButton(): void
    {
        if (!$this->plain) {
            $this->class('btn');
        }

        if (is_string($this->icon)) {
            $this->icon = Icon::make(icon: $this->icon);
        }
    }
}
