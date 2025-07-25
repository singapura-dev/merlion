<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Closure;
use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasRoute;
use Merlion\Components\Concerns\Admin\HasToast;

/**
 */
class Admin extends Html
{
    use HasMenus;
    use HasToast;
    use HasRoute;

    const SECTION_HEADER_RIGHT = 'header-right';

    protected string $view = 'merlion::layouts.admin';

    protected array $serving = [];
    protected array $sections = [];
    protected bool $served = false;

    public function full(): static
    {
        $this->view = 'merlion::layouts.full';
        return $this;
    }

    public function serving(Closure $callback): void
    {
        $this->serving[] = $callback;
    }

    public function served(): void
    {
        if ($this->served) {
            return;
        }
        foreach ($this->serving as $callback) {
            call_user_func($callback->bindTo($this, $this));
        }
        $this->served = true;
    }

    public function section($position, $content): static
    {
        if (empty($this->sections[$position])) {
            $this->sections[$position] = [];
        }

        $content = is_array($content) ? $content : [$content];
        array_push($this->sections[$position], ...$content);

        return $this;
    }

    public function getSections($position): array
    {
        return $this->sections[$position] ?? [];
    }

    public function getGuard()
    {
        if (empty($this->guard)) {
            return auth()->guard();
        }

        return $this->evaluate($this->guard);
    }
}
