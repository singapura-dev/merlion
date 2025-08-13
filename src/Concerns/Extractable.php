<?php
declare(strict_types=1);

namespace Merlion\Concerns;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\View\InvokableComponentVariable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

trait Extractable
{
    protected static array $propertyCache = [];
    protected static array $methodCache = [];
    protected static array $exceptProperty = [];
    protected static array $exceptMethod = [];

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
            $values[$property] = evaluate($this->{$property}, $this);
        }

        return $values;
    }

    protected function shouldIgnoreProperty($name): bool
    {
        return str_starts_with($name, '_') || in_array($name, static::$exceptProperty);
    }

    protected function extractPublicMethods(): array
    {
        $class = get_class($this);

        if (!isset(static::$methodCache[$class])) {
            $reflection = new ReflectionClass($this);

            static::$methodCache[$class] = (new Collection($reflection->getMethods(ReflectionMethod::IS_PUBLIC)))
                ->reject(fn(ReflectionMethod $method) => $this->shouldIgnoreMethod($method->getName()))
                ->map(fn(ReflectionMethod $method) => $method->getName());
        }

        $values = [];

        foreach (static::$methodCache[$class] as $method) {
            $values[$method] = $this->createVariableFromMethod(new ReflectionMethod($this, $method));
        }

        return $values;
    }

    protected function shouldIgnoreMethod($name): bool
    {
        return str_starts_with($name, '_') || in_array($name, static::$exceptMethod);
    }

    protected function createVariableFromMethod(ReflectionMethod $method): Closure|InvokableComponentVariable
    {
        return $method->getNumberOfParameters() === 0
            ? $this->createInvokableVariable($method->getName())
            : Closure::fromCallable([$this, $method->getName()]);
    }

    protected function createInvokableVariable(string $method): InvokableComponentVariable
    {
        return new InvokableComponentVariable(function () use ($method) {
            return $this->{$method}();
        });
    }
}
