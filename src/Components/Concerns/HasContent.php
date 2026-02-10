<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Merlion\Components\Element;

trait HasContent
{
    const string POSITION_DEFAULT = 'default';
    protected array $content = [];

    public function content($args = null, $position = null): static
    {
        $position = $position ?? static::POSITION_DEFAULT;
        if (empty($this->content[$position])) {
            $this->content[$position] = [];
        }
        $args = is_array($args) ? $args : [$args];
        foreach ($args as $arg) {
            if ($arg instanceof Element) {
                $arg->parent($this);
            }
            $this->content[$position][] = $arg;
        }
        return $this;
    }

    public function getContent($position = null): array
    {
        $position = $position ?? static::POSITION_DEFAULT;
        return $this->content[$position] ?? [];
    }
}
