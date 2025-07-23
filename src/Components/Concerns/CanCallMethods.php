<?php

namespace Merlion\Components\Concerns;

use Illuminate\Support\Str;

trait CanCallMethods
{
    protected static array $ignoreMethods = [];

    public function callMethods($startWith, ...$args): void
    {
        $self = static::class;

        $methods = array_filter(get_class_methods($self), function ($method) use ($startWith) {
            if (in_array($method, $this->shouldIgnoreMethods())) {
                return false;
            }
            return Str::startsWith($method, $startWith);
        });

        foreach ($methods as $method) {
            $this->$method(...$args);
        }
    }

    protected function shouldIgnoreMethods(): array
    {
        return array_merge([
            'setup',
            'build',
            'render',
            'set',
            'get',
            'context',
            'evaluate',
        ], static::$ignoreMethods);
    }
}
