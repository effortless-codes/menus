<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\Menu;
use Winata\Menu\Object\MenuGroup;

class AddMenu
{

    protected ?MenuCollection $menus = null;

    /**
     * @return MenuCollection
     */
    protected function getFactory(): MenuCollection
    {
        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
        return $this->menus;
    }

    public MenuGroup|Menu $menu;

    public function __construct(MenuGroup|Menu $menu)
    {
        $this->menus = static::getFactory();
        $this->menu = $menu;
    }

    public function allMenus(bool $resolvedOnly = true): MenuCollection
    {

        if (!$this->menus instanceof MenuCollection) {
            return new MenuCollection();
        }

        return $this->menus
            ->filter(function ($menu) use ($resolvedOnly) {
                if ($menu instanceof Menu) {
                    return $menu->resolver === $resolvedOnly;
                }
                return false;
            });
    }

    public function getMenu($title): Menu
    {
        return $this->menus->where(key: 'title', operator: '=', value: $title)->first();
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
            $currentMenu = $this->getMenu(title: $title);
            $menus = $menus(new AddMenu(menu: $currentMenu));
            /** @var AddMenu $menus */
            $menus->allMenus()->each(function ($menu) use ($currentMenu) {
                $currentMenu->menus->add(item: $menu);
            });
        }

        return $this;
    }
}
