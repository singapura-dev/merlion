<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait HasStaticCallbacks
{
    protected static array $callbacks = [];

    public static function callback($callback, $type = 'setup'): void
    {
        if (empty(self::$callbacks[$type])) {
            static::$callbacks[$type] = [];
        }
        static::$callbacks[$type][] = $callback;
    }

    protected function renderHasStaticCallbacks(): void
    {
        $this->runCallbacks('render');
    }

    protected function setupHasStaticCallbacks(): void
    {
        $this->runCallbacks();
    }

    protected function runCallbacks($type = 'setup'): void
    {
        foreach (static::$callbacks[$type] ?? [] as $callback) {
            call_user_func($callback->bindTo($this, $this));
        }
    }

}
