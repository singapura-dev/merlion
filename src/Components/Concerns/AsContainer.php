<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsContainer
{
    public array $content = [];

    const POSITION_DEFAULT = 'default';

    public function content($args, $position = null): static
    {
        $position = $position ?? static::POSITION_DEFAULT;
        if (empty($this->content[$position])) {
            $this->content[$position] = [];
        }
        $args = is_array($args) ? $args : [$args];
        array_push($this->content[$position], ...$args);
        return $this;
    }

    public function getContent($position = null): array
    {
        $position = $position ?? static::POSITION_DEFAULT;
        return $this->content[$position] ?? [];
    }
}
