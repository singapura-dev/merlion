<?php
declare(strict_types=1);

namespace Merlion\Concerns;

trait WithCallbackHooks
{
    protected static array $staticCallbackHooks = [];
    protected array $callbackHooks = [];

    public static function addStaticHook($action, callable $callback, int $priority = 0): void
    {
        if (!isset(static::$staticCallbackHooks[$action])) {
            static::$staticCallbackHooks[$action] = [];
        }
        if (!isset(static::$staticCallbackHooks[$action][$priority])) {
            static::$staticCallbackHooks[$action][$priority] = [];
        }
        static::$staticCallbackHooks[$action][$priority][] = $callback;
    }

    public static function callStaticHooks($action, ...$args): void
    {
        if (empty(static::$staticCallbackHooks[$action])) {
            return;
        }

        krsort(static::$staticCallbackHooks[$action]);

        foreach (static::$staticCallbackHooks[$action] as $callbacks) {
            foreach ($callbacks as $callback) {
                $callback(...$args);
            }
        }
    }

    public function addHook($action, callable $callback, int $priority = 0): static
    {
        if (!isset($this->callbackHooks[$action])) {
            $this->callbackHooks[$action] = [];
        }
        if (!isset($this->callbackHooks[$action][$priority])) {
            $this->callbackHooks[$action][$priority] = [];
        }
        $this->callbackHooks[$action][$priority][] = $callback;
        return $this;
    }

    public function callHooks($action, ...$args): void
    {
        if (empty($this->callbackHooks[$action])) {
            return;
        }

        krsort($this->callbackHooks[$action]);

        foreach ($this->callbackHooks[$action] as $callbacks) {
            foreach ($callbacks as $callback) {
                $callback(...$args);
            }
        }
    }
}
