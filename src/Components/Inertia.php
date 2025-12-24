<?php

namespace Merlion\Components;

class Inertia extends Renderable
{
    protected mixed $page = '';

    public static string $root = 'merlion::inertia';

    public static array $resources = ['resources/js/app.tsx'];
    public static string $buildDirectory = 'build';

    public static function withResources($resources): void
    {
        static::$resources = $resources;
    }

    public static function withBuildDirectory($buildDirectory): void
    {
        static::$buildDirectory = $buildDirectory;
    }

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        if (is_string($args[0] ?? null)) {
            $this->page($args[0]);
        }

        if (is_array($args[1] ?? null)) {
            $this->context($args[1]);
        }
    }

    public function page($page): static
    {
        $this->page = $page;
        return $this;
    }

    public function getPage(): string
    {
        return $this->evaluate($this->page);
    }

    protected function __render(...$args)
    {
        return \Inertia\Inertia::render($this->getPage(), $args[1] ?? [])->toResponse(request())->getContent();
    }
}
