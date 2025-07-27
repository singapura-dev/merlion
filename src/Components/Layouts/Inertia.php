<?php

namespace Merlion\Components\Layouts;

use Merlion\Components\Renderable;

class Inertia extends Renderable
{
    public $view = 'merlion::layouts.inertia';
    public string $page = '';
    public array $resource = [];

    public function resource($resource): static
    {
        $resource       = is_array($resource) ? $resource : func_get_args();
        $this->resource = array_merge($this->resource, $resource);
        array_push($this->resource, ...$resource);
        return $this;
    }

    public function render(): mixed
    {
        \Inertia\Inertia::setRootView($this->view);
        \Inertia\Inertia::share([
            'lang' => app()->getLocale(),
        ]);
        return \Inertia\Inertia::render($this->page, $this->data())->toResponse(request())->getContent();
    }
}
