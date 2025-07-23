<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasAttributes
{
    public ?ComponentAttributeBag $attributes = null;

    public function withAttributes(array $attributes): static
    {
        $this->attributes = $this->attributes ?: $this->newAttributeBag();
        $this->attributes = $this->attributes->merge($attributes);
        return $this;
    }

    /**
     * Set default attributes
     */
    public function defaultAttributes($attributes): static
    {
        $this->attributes = $this->attributes ?: $this->newAttributeBag();
        foreach ($attributes as $key => $value) {
            if ($this->attributes->has($key)) {
                continue;
            }
            $this->withAttributes([$key => $value]);
        }
        return $this;
    }

    protected function getDefaultAttributes(): array
    {
        return [];
    }

    public function class($class): static
    {
        return $this->withAttributes(['class' => $class]);
    }

    public function removeClass($class = null): static
    {
        if (empty($class)) {
            $this->attributes['class'] = null;
            return $this;
        }
        $classes   = $this->attributes['class'];
        $class_arr = explode(' ', $classes);
        unset($class_arr[array_search($class, $class_arr)]);
        $this->attributes['class'] = implode(' ', $class_arr);
        return $this;
    }

    public function style($style): static
    {
        return $this->withAttributes(['style' => $style]);
    }

    protected function newAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag();
    }
}
