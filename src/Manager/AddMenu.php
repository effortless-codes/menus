<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Abstracts\Menus;
use Winata\Menu\Object\Menu;
use Winata\Menu\Object\MenuGroup;

class AddMenu extends Menus
{

    public function __construct(public MenuGroup|Menu $menu)
    {
    }

    public function getMenu($title): Menu
    {
        return $this->menu->menus->where('title', $title)->first();
    }

    public function addMenu(
        string $title = 'default',
        string $url = '#',
        callable $menus = null
    )
    {
        $this->menu->menus->add(new Menu($title, $url));

        $currentMenu = $this->getMenu($title);

        if (!empty($menus)) {
            $menus = $menus(new AddMenu($currentMenu));
            $currentMenu->menus->add($menus);
        }

        return $this;
    }
}
