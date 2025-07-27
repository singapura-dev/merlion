<?php
declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsButton
{
    public bool $plain = false;
    public mixed $color = null;
    public mixed $size = null;

    public function plain($plain = true): static
    {
        $this->plain = $plain;
        return $this;
    }

    public function renderAsButton(): void
    {

        if (!$this->plain) {
            $this->class('btn');
        }

        if (!empty($this->size)) {
            $this->class('btn-' . $this->evaluate($this->size));
        }

        if (!empty($this->color)) {
            $this->class('btn-' . $this->evaluate($this->color));
        }
    }

    public function color($color = 'primary'): static
    {
        $this->color = $color;
        return $this;
    }

    public function size($size): static
    {
        $this->size = $size;
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
        return $this->color('primary');
    }

    public function secondary(): static
    {
        return $this->color('secondary');
    }

    public function success(): static
    {
        return $this->color('success');
    }

    public function danger(): static
    {
        return $this->color('danger');
    }

    public function warning(): static
    {
        return $this->color('warning');
    }

    public function info(): static
    {
        return $this->color('info');
    }

    public function ghost(): static
    {
        return $this->class('btn-ghost');
    }

    public function square(): static
    {
        return $this->class('btn-square');
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
        return $this->size('xs');
    }

    public function sm(): static
    {
        return $this->size('sm');
    }

    public function md(): static
    {
        return $this->size('md');
    }

    public function lg(): static
    {
        return $this->size('lg');
    }

    public function xl(): static
    {
        return $this->size('xl');
    }
}
