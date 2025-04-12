<?php

namespace Winata\Menu\Manager;

use Closure;
use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\Menu;
use Winata\Menu\Object\MenuGroup;

/**
 * Class AddMenu
 *
 * Manage and build dynamic menu structure.
 *
 * @package Winata\Menu\Manager
 */
class AddMenu
{
    /**
     * The menu collection container.
     *
     * @var MenuCollection|null
     */
    protected ?MenuCollection $menus = null;

    /**
     * The root menu item (could be MenuGroup or Menu).
     *
     * @var MenuGroup|Menu
     */
    public MenuGroup|Menu $menu;

    /**
     * Constructor to initiate menu manager.
     *
     * @param MenuGroup|Menu $menu
     */
    public function __construct(MenuGroup|Menu $menu)
    {
        $this->menus = static::getFactory();
        $this->menu = $menu;
    }

    /**
     * Get the internal MenuCollection instance.
     *
     * @return MenuCollection
     */
    protected static function getFactory(): MenuCollection
    {
        $instance = null;

        if (!$instance instanceof MenuCollection) {
            $instance = new MenuCollection();
        }

        return $instance;
    }

    /**
     * Retrieve all registered menus, with optional resolver check.
     *
     * @param bool $resolvedOnly
     * @return MenuCollection
     */
    public function allMenus(bool $resolvedOnly = true): MenuCollection
    {
        if (!$this->menus instanceof MenuCollection) {
            return new MenuCollection();
        }

        return $this->menus->filter(function ($menu) use ($resolvedOnly) {
            return $menu instanceof Menu && $menu->resolver === $resolvedOnly;
        });
    }

    /**
     * Find a menu item by its title.
     *
     * @param string $title
     * @return Menu|null
     */
    public function getMenu(string $title): ?Menu
    {
        return $this->menus->firstWhere('title', '=', $title);
    }

    /**
     * Add a menu item to the current group.
     *
     * @param string             $title
     * @param string|null        $routeName
     * @param string|null        $activeRouteName
     * @param string|null        $icon
     * @param Closure|bool       $resolver
     * @param MenuType           $menuType
     * @param callable|null      $menus
     *
     * @return static
     */
    public function addMenu(
        string        $title = 'menu',
        ?string       $routeName = null,
        ?string       $activeRouteName = null,
        ?string       $icon = null,
        Closure|bool  $resolver = true,
        MenuType      $menuType = MenuType::ROUTE,
        ?callable     $menus = null,
    ): static {
        $this->menus->add(new Menu(
            routeName: $routeName,
            title: $title,
            activeRouteName: $activeRouteName,
            icon: $icon,
            resolver: $resolver,
            menuType: $menuType,
        ));

        if ($menus) {
            $currentMenu = $this->getMenu($title);

            if ($currentMenu) {
                /** @var AddMenu $subMenus */
                $subMenus = $menus(new self($currentMenu));

                $subMenus->allMenus()->each(function ($menu) use ($currentMenu) {
                    $currentMenu->menus->add($menu);
                });
            }
        }

        return $this;
    }
}
