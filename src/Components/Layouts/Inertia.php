<?php

namespace Merlion\Components\Layouts;

use Merlion\Components\Renderable;

class Inertia extends Renderable
{
    public string $view = 'merlion::layouts.inertia';
    public string $page = '';
    public array $resource = [];

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function resource($resource)
    {
        $resource       = is_array($resource) ? $resource : func_get_args();
        $this->resource = array_merge($this->resource, $resource);
        array_push($this->resource, ...$resource);
        return $this;
    }

    public function render()
    {
        \Inertia\Inertia::setRootView($this->view);
        \Inertia\Inertia::share([
            'lang' => app()->getLocale(),
        ]);
        return \Inertia\Inertia::render($this->page, $this->data())->toResponse(request())->getContent();
    }
}
