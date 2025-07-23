<?php

declare(strict_types=1);

namespace Merlion\Components\Layouts;

use Merlion\Components\Concerns\Admin\HasMenus;
use Merlion\Components\Concerns\Admin\HasToast;

class Admin extends Html
{
    use HasMenus;
    use HasToast;

    protected string $view = 'merlion::layouts.page';

    public function full(): static
    {
        $this->view = 'merlion::layouts.full';
        return $this;
    }
}
