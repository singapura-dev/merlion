<?php

declare(strict_types=1);

namespace Merlion\Components;

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
    protected static array $exceptProperty = [
        'attributes',
    ];

    /**
     * View path
     * @var mixed
     */
    public $view = '';

    public function __construct(...$args)
    {
        //
    }

    public static function make(...$args): static
    {
        $instance = new static(...$args);
        foreach ($args as $key => $value) {
            if ($key === 0 && is_array($args[0] ?? null)) {
                foreach ($args[0] as $_key => $_value) {
                    if (is_string($_key) && (
                            public_property_exists($instance, $_key) || public_method_exists($instance, $_key)
                        )) {

                        if ($_key === 'attributes') {
                            $instance->withAttributes($_value);
                        } else {
                            $instance->{$_key}($_value);
                        }
                    }
                }
                break;
            }
            if (is_string($key) && (public_property_exists($instance, $key) || public_method_exists($instance, $key))) {
                $instance->{$key}($value);
            }
        }
        $instance->callMethods('setup', ...$args);
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

    public function render(): mixed
    {
        $this->callMethods('building');
        $this->callMethods('render');

        return view($this->getView(), $this->data());
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function setView($view): static
    {
        $this->view = $view;
        return $this;
    }

    public static function clone($renderable)
    {
        if (is_array($renderable)) {
            return array_map(function ($value) {
                return static::clone($value);
            }, $renderable);
        }
        if (is_object($renderable)) {
            return clone $renderable;
        }
        return $renderable;
    }

    protected function data(): array
    {
        $this->defaultAttributes($this->getDefaultAttributes());
        $context = [
            'self'       => $this,
            'id'         => $this->getId(),
            'attributes' => $this->getAttributes(),
        ];
        foreach ($this->_context as $key => $value) {
            $context[$key] = $this->evaluate($value);
        }

        $data = array_merge($this->extractPublicProperties(), $context);
        if (!empty($data['attributes']['style'])) {
            $class_random = Str::random(8);
            admin()->styles(<<<STYLE
.$class_random {
    {$data['attributes']['style']}
}
STYLE
            );
            $data['attributes'] = ($data['attributes'])->merge(['class' => $class_random]);
            unset($data['attributes']['style']);
        }
        return $data;
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
            $values[$property] = $this->evaluate($this->{$property});
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
