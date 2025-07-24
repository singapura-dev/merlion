<?php

declare(strict_types=1);

namespace Merlion\Components\Table\Filters;

use Merlion\Components\Renderable;

/**
 * @method string getName()
 */
class Sort extends Renderable
{
    public string $name = '';
    public string $field = '';
    public string $label = '';

    public function selected()
    {
        return request('sort') == $this->getName();
    }
}
