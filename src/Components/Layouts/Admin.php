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

    const string POSITION_HEADER_RIGHT = 'header-right';

    public $view = 'merlion::layouts.admin';

    protected array $serving = [];
    protected bool $served = false;

    public function full(): static
    {
        $this->view = 'merlion::layouts.full';
        return $this;
    }

    public function theme($color = null, $base = null, $radius = null, $font = null): static
    {
        return $this->withAttributes([
            'data-bs-theme-primary' => $color,
            'data-bs-theme-base'    => $base,
            'data-bs-theme-radius'  => $radius,
            'data-bs-theme-font'    => $font,
        ]);
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


}
