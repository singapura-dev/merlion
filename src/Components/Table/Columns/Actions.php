<?php
declare(strict_types=1);

namespace Merlion\Components\Table\Columns;

use Merlion\Components\Concerns\HasIcon;

class Actions extends Column
{
    use HasIcon;

    public mixed $name = 'actions';

    protected array $actions = [];

    public function actions($action): static
    {
        $action = is_array($action) ? $action : [$action];
        array_push($this->actions, ...$action);
        return $this;
    }

    public function getActions(): array
    {
        $actions = [];
        foreach ($this->actions as $action) {
            $action = deep_clone($action);
            $action->context('model', $this->getModel());
            $actions[] = $action;
        }
        return $actions;
    }

    public function list($class = 'd-flex gap-2'): static
    {
        $this->view = 'merlion::table.columns.actions';
        $this->class($class);
        return $this;
    }

    public function dropdown($class = 'btn btn-ghost btn-sm'): static
    {
        $this->view = 'merlion::table.columns.dropdown';
        $this->class($class);
        return $this;
    }
    protected function defaultLabel(): string
    {
        return '';
    }
}
