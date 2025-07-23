<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Closure;
use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasToast;

/**
 * @method string getHomeUrl()
 */
class Admin extends Html
{
    use HasMenus;
    use HasToast;

    protected string $view = 'merlion::layouts.page';

    public string|Closure|null $homeUrl = '/admin';

    public function full(): static
    {
        $this->view = 'merlion::layouts.full';
        return $this;
    }
}
