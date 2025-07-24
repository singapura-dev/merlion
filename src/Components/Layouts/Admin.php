<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Closure;
use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasRoute;
use Merlion\Components\Concerns\Admin\HasToast;

/**
 * @method string getHome() Get home url
 * @method $this back(string|Closure $url) Set back url
 */
class Admin extends Html
{
    use HasMenus;
    use HasToast;
    use HasRoute;

    protected string $view = 'merlion::layouts.page';

    protected array $serving = [];
    protected bool $served = false;

    public string|Closure|null $home = '/admin';
    public string|Closure|null $back = null;

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
}
