<?php
declare(strict_types=1);

namespace Merlion\Concerns;

use Illuminate\Support\Arr;
use Merlion\Components\Element;

trait WithContext
{
    protected array $context = [];

    public function context(string|array $key, $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->context[$k] = $v;
            }
            return $this;
        }
        $this->context[$key] = $value;
        return $this;
    }

    public function getContext($key = null, $default = null): mixed
    {
        if ($key === null) {
            return $this->context;
        }
        return $this->getParentContext($this, $key, $default);
    }

    protected function getParentContext($item, $key, $default = null): mixed
    {
        if ($item->hasContext($key)) {
            return Arr::get($item->context, $key);
        }

        if (isset($item->parent) && $item->parent instanceof Element) {
            return $this->getParentContext($item->parent, $key);
        }

        return $default;
    }

    public function hasContext($key): bool
    {
        return Arr::has($this->context, $key);
    }

}
