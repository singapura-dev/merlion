<?php

namespace Merlion\Components\Concerns\Admin;

trait HasMenus
{
    const MENU_POSITION_MAIN = 'main';
    const MENU_POSITION_USER = 'user';

    protected array $menus = [];

    public function menus($menus, $position = null): static
    {
        $position = $position ?: static::MENU_POSITION_MAIN;
        if (empty($this->menus[$position])) {
            $this->menus[$position] = [];
        }
        $menus = is_array($menus) ? $menus : [$menus];
        array_push($this->menus[$position], ...$menus);
        return $this;
    }

    public function getMenus($position = null): array
    {
        $position = $position ?: static::MENU_POSITION_MAIN;
        return $this->menus[$position] ?? [];
    }
}
