<?php

declare(strict_types=1);

namespace Merlion\Components;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Merlion\Components\Concerns\CanCallMethods;
use Merlion\Components\Concerns\HasAttributes;
use Merlion\Components\Concerns\HasContext;
use Merlion\Components\Concerns\HasId;
use ReflectionClass;
use ReflectionProperty;

abstract class Renderable
{
    use CanCallMethods;
    use HasAttributes;
    use HasContext;
    use HasId;

    protected static array $propertyCache = [];
    protected static array $exceptProperty = [];

    protected string $view = '';
    protected Closure $renderUsing;

    public static function make(...$arguments): static
    {
        $instance = new static(...$arguments);
        $instance->callMethods('setup');
        return $instance;
    }

    public function __call($method, $args)
    {
        if (Str::startsWith($method, 'set')) {
            $property = Str::camel(Str::after($method, 'set'));
            if (public_property_exists($this, $property)) {
                $this->{$property} = $args[0];
                return $this;
            }
        }

        if (Str::startsWith($method, 'get')) {
            $property = Str::camel(Str::after($method, 'get'));
            if (property_exists($this, $property)) {
                if (isset($this->{$property})) {
                    return $this->evaluate($this->{$property});
                }
            }
        }

        if (public_property_exists($this, $method)) {
            $this->{$method} = $args[0] ?? null;
            return $this;
        }
    }

    public function render()
    {
        $this->callMethods('building');
        $this->callMethods('render');

        if (!empty($this->renderUsing)) {
            return call_user_func($this->renderUsing->bindTo($this, $this), $this->data());
        }
        return view($this->getView(), $this->data());
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function display(Closure $renderUsing): static
    {
        $this->renderUsing = $renderUsing;
        return $this;
    }

    protected function data(): array
    {
        $this->defaultAttributes($this->getDefaultAttributes());
        $context = [
            'self' => $this,
            'id'   => $this->getId(),
        ];
        foreach ($this->_context as $key => $value) {
            $context[$key] = $this->evaluate($value);
        }
        return array_merge($this->extractPublicProperties(), $context);
    }

    protected function extractPublicProperties(): array
    {
        $class = get_class($this);

        if (!isset(static::$propertyCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$propertyCache[$class] = (new Collection($reflection->getProperties(ReflectionProperty::IS_PUBLIC)))
                ->reject(fn(ReflectionProperty $property) => $property->isStatic())
                ->reject(fn(ReflectionProperty $property) => $this->shouldIgnoreProperty($property->getName()))
                ->map(fn(ReflectionProperty $property) => $property->getName())
                ->all();
        }

        $values = [];

        foreach (static::$propertyCache[$class] as $property) {
            $values[$property] = $this->{$property};
        }

        return $values;
    }

    protected function shouldIgnoreProperty($name): bool
    {
        return str_starts_with($name, '_') || in_array($name, static::$exceptProperty);
    }

    protected function evaluate($value)
    {
        return evaluate($value, $this);
    }

}
