<?php

declare(strict_types=1);

namespace Merlion\Components\Pages\Crud;

class EditRowButton extends RowActionButton
{
    public function setupViewRowButton(...$args): void
    {
        $this->label(__('merlion::base.edit'))
            ->ghost()
            ->icon('ri-edit-line');
    }

    public function renderViewRowButton(): void
    {
        $this->link(admin()->route($this->route . '.edit', $this->getModel()));
    }
}
