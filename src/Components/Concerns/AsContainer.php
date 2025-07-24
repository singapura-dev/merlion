<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsContainer
{
    public array $content = [];

    public function setupContainer(...$args): void
    {
        foreach ($args as $key => $value) {
            if ($key === 0) {
                $content = is_array($value) ? $value : func_get_args();
                $this->content($content);
            }
            break;
        }
    }

    public function content($args): static
    {
        $args = is_array($args) ? $args : func_get_args();
        array_push($this->content, ...$args);
        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
