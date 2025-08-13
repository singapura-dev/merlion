<?php
declare(strict_types=1);

namespace Merlion\Concerns;

trait HasBehaviors
{
    protected static array $behaviors = [];

    public static function addBehavior($name, $behavior): void
    {
        static::$behaviors[$name] = $behavior;
    }

    public function callBehaviors($method, $arguments): mixed
    {
        foreach (static::$behaviors as $behavior) {
            if (method_exists($behavior, $method)) {
                $behavior->host($this);
                return call_user_func_array([$behavior, $method], $arguments);
            }
        }
    }
}
