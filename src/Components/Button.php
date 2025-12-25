<?php

declare(strict_types=1);

namespace Merlion\Components;

use Merlion\Components\Concerns\AsCell;
use Merlion\Components\Concerns\AsLink;
use Merlion\Components\Concerns\HasIcon;
use Merlion\Components\Concerns\HasModal;

class Button extends Renderable
{
    use AsCell;
    use AsLink;
    use HasIcon;
    use HasModal;

    protected array $defaultAttributes = [
        'class' => 'btn',
    ];

    public function confirm($confirm): static
    {
        return $this->withAttributes(['data-confirm' => $confirm]);
    }

    public function submit(): static
    {
        return $this->withAttributes(['type' => 'submit']);
    }

    public function primary(): static
    {
        $this->class('btn-primary');
        return $this;
    }
}
