<?php

declare(strict_types=1);

namespace Merlion\Components\Pages\Crud;

class DeleteRowButton extends RowActionButton
{
    public function setupViewRowButton(...$args): void
    {
        $this->label(__('merlion::base.delete'))
            ->danger()
            ->icon('ri-delete-bin-line');
    }

    public function renderViewRowButton(): void
    {
        $this->action(admin()->route($this->route . '.show', $this->getModel()), 'delete')
            ->confirm('Are you sure?');
    }
}
