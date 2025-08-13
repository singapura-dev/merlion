<?php

declare(strict_types=1);

namespace Merlion\Components\Concerns;

use Merlion\Components\Containers\Modal;

trait HasModal
{
    public mixed $modal = null;

    public function modal($modal): static
    {
        if (is_callable($modal)) {
            $this->modal = Modal::make();
            call_user_func($modal, $this->modal);
        } else {
            $this->modal = $modal;
        }

        $this->withAttributes([
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#' . $this->modal->getId(),
        ]);

        admin()->content($this->modal, 'extra');

        return $this;
    }
}
