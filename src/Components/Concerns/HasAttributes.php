<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasAttributes
{
    public array $attributes = [];

    final const string ATTRIBUTES_DEFAULT = 'default';

    final public function withAttributes(array $attributes, $position = null): static
    {
        $position = $position ?: static::ATTRIBUTES_DEFAULT;
        if (empty($this->attributes[$position])) {
            $this->attributes[$position] = $this->newAttributeBag();
        }
        $this->attributes[$position] = $this->attributes[$position]->merge($attributes);
        return $this;
    }

    public function getAttributes($position = null): ComponentAttributeBag
    {
        $position = $position ?: static::ATTRIBUTES_DEFAULT;
        if (empty($this->attributes[$position])) {
            $this->attributes[$position] = $this->newAttributeBag();
        }
        return $this->attributes[$position];
    }

    /**
     * Set default attributes
     */
    final public function defaultAttributes($attributes, $position = null): static
    {
        if (empty($this->attributes[$position])) {
            $this->attributes[$position] = $this->newAttributeBag();
        }
        $_attributes = $this->attributes[$position];

        foreach ($attributes as $key => $value) {
            if ($_attributes->has($key)) {
                continue;
            }
            $this->withAttributes([$key => $value], $position);
        }
        return $this;
    }

    final public function class($class, $position = null): static
    {
        return $this->withAttributes(['class' => $class], $position);
    }

    final public function removeClass($class = null, $position = null): static
    {
        $position = $position ?: static::ATTRIBUTES_DEFAULT;
        if (empty($this->attributes[$position])) {
            return $this;
        }

        if (empty($class)) {
            $this->attributes[$position] = null;
            return $this;
        }
        $attributes = $this->attributes[$position];
        $classes    = $attributes['class'];
        $class_arr  = explode(' ', $classes);
        unset($class_arr[array_search($class, $class_arr)]);
        $attributes['class']         = implode(' ', $class_arr);
        $this->attributes[$position] = $attributes;
        return $this;
    }

    final public function style($style, $position = null): static
    {
        return $this->withAttributes(['style' => $style], $position);
    }

    protected function getDefaultAttributes(): array
    {
        return [];
    }

    protected function newAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag();
    }
}
