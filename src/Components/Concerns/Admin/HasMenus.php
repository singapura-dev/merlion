<?php

namespace Merlion\Components\Concerns\Admin;

trait HasMenus
{
    const MENU_MAIN     = 'menus';
    const MENU_TOP_USER = 'menus_top_user';

    public function clearMenus($position = 'menus'): static
    {
        return $this->context_clear($position);
    }

    public function menus($menus, $position = 'menus'): static
    {
        $this->context_push($position, $menus);
        return $this;
    }

    public function userMenus($menus): static
    {
        $this->context_push(static::MENU_TOP_USER, $menus);
        return $this;
    }

    public function getUserMenus(): array
    {
        $menus      = $this->get(static::MENU_TOP_USER);
        $user_menus = [];
        foreach ($menus as $menu) {
            if (is_array($menu)) {
                $user_menus = [...$user_menus, ...$menu];
            } else {
                $user_menus[] = $menu;
            }
        }
        return $user_menus;
    }

    public function getMenus($position = 'menus'): array
    {
        return $this->get($position, []);
    }
}
