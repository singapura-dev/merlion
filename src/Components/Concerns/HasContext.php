<?php


declare(strict_types=1);

namespace Merlion\Components\Concerns;

use RuntimeException;

trait HasContext
{
    protected array $_context = [];

    public function set($key, $value = null)
    {
        if (is_string($key)) {
            return $this->context_add($key, $value);
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->context_add($k, $v);
            }
        }

        return $this;
    }

    public function get($key, $default = null)
    {
        return $this->_context[$key] ?? $default;
    }

    public function context_add($key, $value): static
    {

        $this->_context[$key] = $value;
        return $this;
    }

    public function context_clear($key)
    {
        if (isset($this->_context[$key])) {
            unset($this->_context[$key]);
        }
        return $this;
    }

    public function context_push($key, ...$values): static
    {
        if (!$this->isStackable($key)) {
            throw new RuntimeException("Unable to push value onto context stack for key [{$key}].");
        }

        $this->_context[$key] = [
            ...$this->_context[$key] ?? [],
            ...$values,
        ];

        return $this;
    }

    protected function isStackable($key): bool
    {
        return !array_key_exists($key, $this->_context) ||
            (is_array($this->_context[$key]) && array_is_list($this->_context[$key]));
    }

    public function context_only(array $keys): array
    {
        return array_intersect_key($this->_context, array_flip($keys));
    }

    public function context_forget(array|string $keys): static
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        foreach ((array)$keys as $key) {
            unset($this->_context[$key]);
        }

        return $this;
    }
}
