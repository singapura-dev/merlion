<?php

namespace Merlion\Components\Table\BatchActions;

use Merlion\Components\Button;
use Merlion\Components\Containers\Container;
use Merlion\Components\Form\Form;

class BatchAction extends Button
{
    public function action($action, $method = 'post'): static
    {
        return $this->withAttributes(['data-batch-action' => $action, 'data-method' => $method]);
    }
}
