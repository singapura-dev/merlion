<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

class Toggle extends Text
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
}
