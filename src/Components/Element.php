<?php
declare(strict_types=1);

namespace Merlion\Components;

use BadMethodCallException;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Merlion\Components\Concerns\WithAttributes;
use Merlion\Concerns\CanCallMethods;
use Merlion\Concerns\Extractable;
use Merlion\Concerns\HasBehaviors;
use Merlion\Concerns\Makeable;
use Merlion\Concerns\WithCallbackHooks;
use Merlion\Concerns\WithContext;

abstract class Element
{
    use CanCallMethods;
    use Extractable;
    use HasBehaviors;
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Makeable;
    use WithAttributes;
    use WithContext;
    use WithCallbackHooks;

    public function evaluate($value)
    {
        return evaluate($value, $this);
    }

    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        foreach (static::$behaviors as $behavior) {
            if (public_method_exists($behavior, $method)) {
                $behavior->setHost($this);
                return call_user_func_array([$behavior, $method], $parameters);
            }
        }

        if (Str::startsWith($method, 'set')) {
            $property = Str::camel(Str::after($method, 'set'));
            if (public_property_exists($this, $property)) {
                $this->{$property} = $parameters[0];
                return $this;
            }
        }

        if (Str::startsWith($method, 'get')) {
            $property = Str::camel(Str::after($method, 'get'));
            if (property_exists($this, $property)) {
                if (isset($this->{$property})) {
                    return evaluate($this->{$property}, $this);
                }
                return null;
            }
        }

        if (public_property_exists($this, $method)) {
            $this->{$method} = $parameters[0] ?? null;
            return $this;
        }

        throw new BadMethodCallException("Method $method does not exist on " . static::class);
    }
}
