<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

trait AsToggle
{
    public mixed $trueLabel = 'Y';
    public mixed $falseLabel = 'N';

    public function asIcon($icons = null): static
    {
        if (!is_array($icons) || empty($icons)) {
            $icons = [
                '<i class="ti ti-toggle-right text-success"></i>',
                '<i class="ti ti-toggle-left text-muted"></i>',
            ];
        }
        $this->trueLabel  = $icons[0];
        $this->falseLabel = $icons[1];
        return $this;
    }

    public function renderingToogle()
    {
        if (empty($this->displayValueUsing)) {
            $this->displayValueUsing = function ($schema) {
                return $schema->getValue() ? $schema->trueLabel : $this->falseLabel;
            };
        }
    }
}
