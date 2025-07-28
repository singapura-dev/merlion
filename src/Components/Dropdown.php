<?php

declare(strict_types=1);

namespace Merlion\Components;

/**
 * @method $this button(mixed $button) Set button
 */
class Dropdown extends Renderable
{
    public $view = 'merlion::dropdown';

    public mixed $button = null;
    public mixed $menu = null;
    public array $actions = [];

    public function actions($actions): static
    {
        $actions = is_array($actions) ? $actions : [$actions];
        array_push($this->actions, ...$actions);
        return $this;
    }

    public function getActions(): array
    {
        if (empty($this->actions)) {
            return [];
        }

        $actions = [];

        foreach ($this->actions as $action) {
            if (is_string($action)) {
                $action = [
                    'content' => $action,
                ];
            }

            if (is_array($action)) {
                $action = Text::make($action);
            }

            if ($action instanceof Renderable) {
                $actions[] = $action;
            }
        }

        return $actions;
    }

    public function getButton(): ?Renderable
    {
        if (empty($this->button)) {
            return null;
        }

        $button = $this->button;
        if (is_string($button)) {
            $button = [
                'label' => $button,
            ];
        }

        if (is_array($button)) {
            $button = Button::make($button);
        }

        return $button;
    }
}
