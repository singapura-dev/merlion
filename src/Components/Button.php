<?php

declare(strict_types=1);

namespace Merlion\Components;

class Button extends Container
{
    public string $wrapper = 'button';

    public function setupButton()
    {
        $this->class('btn');
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

    public function ghost(): static
    {
        return $this->class('btn-ghost');
    }

    public function outline(): static
    {
        return $this->class('btn-outline');
    }

    public function pill(): static
    {
        return $this->class('btn-pill');
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
        return $this->removeClass('btn ');
    }

    public function action($action, $method = 'post')
    {
        return $this->withAttributes(['data-action' => $action, 'data-method' => $method]);
    }

    public function link($link, $target = '_self'): static
    {
        $this->wrapper = 'a';
        $this->withAttributes(['href' => $link, 'target' => $target]);
        return $this;
    }

    public function icon($icon, $position = 'start', $animate = false): static
    {
        if (empty($this->_children)) {
            $hasLabel = false;
        } else {
            $hasLabel = true;
        }

        if (is_string($icon)) {
            $icon = Icon::make($icon);
        }

        if ($position === 'start') {
            $this->_children = [
                $icon,
                ...$this->_children,
            ];
        }

        if ($position === 'end') {
            $this->content($icon);
        }

        if ($animate) {
            $this->class('btn-animate-icon btn-animate-icon-' . $animate);
        }

        if (!$hasLabel) {
            $this->class('btn-icon');
        }

        return $this;
    }
}
