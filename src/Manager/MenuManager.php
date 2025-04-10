<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Abstracts\Menus;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\MenuGroup;

/**
 * Class MenuManager
 *
 * Static class to manage registration and retrieval of menu groups and menu items.
 *
 * @package Winata\Menu\Manager
 */
class MenuManager extends Menus
{
    /**
     * The main menu collection instance.
     *
     * @var MenuCollection|null
     */
    protected static ?MenuCollection $menus = null;

    /**
     * Get or initialize the singleton menu collection.
     *
     * @return MenuCollection
     */
    protected static function getFactory(): MenuCollection
    {
        if (!static::$menus instanceof MenuCollection) {
            static::$menus = new MenuCollection();
        }

        return static::$menus;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        // intentionally left blank
    }

    /**
     * Get menu(s) optionally filtered by name and/or group.
     *
     * @param array|string|null $name
     * @param array|string|null $group
     * @return MenuCollection
     */
    public static function get(null|array|string $name = null, null|array|string $group = null): MenuCollection
    {
        if (!static::$menus instanceof MenuCollection) {
            return new MenuCollection();
        }

        return static::$menus
            ->when($name !== null, function (MenuCollection $query) use ($name) {
                return is_array($name)
                    ? $query->whereIn('name', $name)
                    : $query->where('name', '=', $name);
            })
            ->when($group !== null, function (MenuCollection $query) use ($group) {
                return is_array($group)
                    ? $query->whereIn('group', $group)
                    : $query->where('group', '=', $group);
            });
    }

    /**
     * Get a single menu group by its name and group.
     *
     * @param string $name
     * @param string $group
     * @return MenuGroup|null
     */
    public static function getGroup(string $name, string $group): ?MenuGroup
    {
        return static::$menus
            ?->where('name', '=', $name)
            ->where('group', '=', $group)
            ->first();
    }

    /**
     * Register a new menu group and its nested menus via a callback.
     *
     * @param string|null $name
     * @param string|null $group
     * @param string|null $icon
     * @param callable|null $menus
     * @return static
     */
    public static function setGroup(
        ?string $name = null,
        ?string $group = null,
        ?string $icon = null,
        ?callable $menus = null,
    ): static {
        static::$menus = static::getFactory();

        $menuGroup = new MenuGroup(name: $name, group: $group, icon: $icon);
        static::$menus->add($menuGroup);

        if ($menus) {
            /** @var MenuGroup|null $currentGroup */
            $currentGroup = static::getGroup(name: $name, group: $group);

            if ($currentGroup) {
                /** @var AddMenu $addMenu */
                $addMenu = $menus(new AddMenu(menu: $currentGroup));

                $addMenu->allMenus()->each(function ($menu) use ($currentGroup) {
                    $currentGroup->menus->add($menu);
                });
            }
        }

        return new static();
    }
}
