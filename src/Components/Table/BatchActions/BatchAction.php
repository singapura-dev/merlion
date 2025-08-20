<?php

namespace Merlion\Components\Table\BatchActions;

use Merlion\Components\Button;

class BatchAction extends Button
{
    protected array $defaultAttributes = [
        'class' => '',
    ];

    public function action($action, $method = 'post'): static
    {
        return $this->withAttributes(['data-batch-action' => $action, 'data-method' => $method]);
    }
}
