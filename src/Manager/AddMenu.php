<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\Menu;
use Winata\Menu\Object\MenuGroup;

class AddMenu
{

    protected static ?MenuCollection $menus = null;

    /**
     * @return MenuCollection
     */
    protected static function getFactory(): MenuCollection
    {
        if (!static::$menus instanceof MenuCollection) {
            static::$menus = new MenuCollection();
        }
        return static::$menus;
    }

    public static MenuGroup|Menu $menu;

    public function __construct(MenuGroup|Menu $menu)
    {
        self::$menu = $menu;
        static::$menus = static::getFactory();
    }

    public static function allMenus(bool $resolvedOnly = true): MenuCollection
    {
        return self::$menus->filter(function ($menu) use ($resolvedOnly) {
            if ($menu instanceof Menu) {
                return $menu->resolver === $resolvedOnly;
            }
            return false;
        });
    }

    public static function getMenu($title): Menu
    {
        return static::$menus->where(key: 'title', operator: '=', value: $title)->first();
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
    public static function addMenu(
        string        $title = 'menu',
        ?string       $routeName = null,
        ?string       $activeRouteName = null,
        ?string       $icon = null,

        \Closure|bool $resolver = true,
        MenuType      $menuType = MenuType::ROUTE,
        callable      $menus = null,
    ): static
    {
        static::$menus->add(new Menu(
            routeName: $routeName,
            title: $title,
            activeRouteName: $activeRouteName,
            icon: $icon,
            resolver: $resolver,
            menuType: $menuType,
        ));

        if (!empty($menus)) {
            $currentMenu = static::getMenu(title: $title);
            $menus = $menus(new AddMenu(menu: $currentMenu));
            $currentMenu->menus->add(item: $menus);
        }

        return new static(menu: self::$menu);
    }
}
