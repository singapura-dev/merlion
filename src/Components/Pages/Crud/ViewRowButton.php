<?php

declare(strict_types=1);

namespace Merlion\Components\Pages\Crud;

class ViewRowButton extends RowActionButton
{
    public function setupViewRowButton(...$args): void
    {
        $this->label(__('merlion::base.view'))
            ->ghost()
            ->icon('ri-eye-line');
    }

    public function renderViewRowButton(): void
    {
        $this->link(admin()->route($this->route . '.show', $this->getModel()));
    }
}
