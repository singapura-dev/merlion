<?php
declare(strict_types=1);

namespace Merlion\Concerns;

use Illuminate\Support\Str;

trait CanCallMethods
{
    protected array $ignoreMethods = [
        'rendering',
        'building',
        'registering',
    ];

    public function callMethods($startWith, ...$args): void
    {
        $self = static::class;

        $methods = array_filter(get_class_methods($self), function ($method) use ($startWith) {
            if ($method === $startWith) {
                return false;
            }
            if (in_array($method, $this->ignoreMethods)) {
                return false;
            }
            return Str::startsWith($method, $startWith);
        });

        foreach ($methods as $method) {
            $this->$method(...$args);
        }
    }
}
