<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

class Toggle extends Text
{
    public mixed $yesLabel = 'Y';
    public mixed $noLabel = 'N';

    public function asIcon($icons = null): static
    {
        if (!is_array($icons) || empty($icons)) {
            $icons = [
                '<i class="ti ti-toggle-right text-success"></i>',
                '<i class="ti ti-toggle-left text-muted"></i>',
            ];
        }
        $this->yesLabel = $icons[0];
        $this->noLabel  = $icons[1];
        return $this;
    }
}
