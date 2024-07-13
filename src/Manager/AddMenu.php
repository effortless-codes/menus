<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Abstracts\Menus;
use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\Menu;
use Winata\Menu\Object\MenuGroup;

class AddMenu extends Menus
{

    public function __construct(public MenuGroup|Menu $menu)
    {
        $this->menus = $this->getFactory();
    }

    public function allMenus(bool $resolvedOnly = true): MenuCollection
    {
        return $this->menus->filter(fn (Menu $m) => $m->resolver === $resolvedOnly);
    }

    public function getMenu($title): Menu
    {
        return $this->menus->where('title', $title)->first();
    }

    /**
     * @param string|null $routeName
     * @param string $title
     * @param string|null $activeRouteName
     * @param string|null $icon
     * @param \Closure|bool $resolver
     * @param MenuType $menuType
     * @param callable|null $menus
     * @return $this
     */
    public function addMenu(
        string        $title = 'menu',
        ?string       $routeName = null,
        ?string       $activeRouteName = null,
        ?string       $icon = null,

        \Closure|bool $resolver = true,
        MenuType      $menuType = MenuType::ROUTE,
        callable      $menus = null,
    ): static
    {
        $this->menus->add(new Menu(
            routeName: $routeName,
            title: $title,
            activeRouteName: $activeRouteName,
            icon: $icon,
            resolver: $resolver,
            menuType: $menuType,
        ));

        if (!empty($menus)) {
            $currentMenu = $this->getMenu($title);
            $menus = $menus(new AddMenu($currentMenu));
            $menus->allMenus()->each(function ($menu) use ($currentMenu) {
                $currentMenu->menus->add($menu);
            });
        }

        return $this;
    }
}
