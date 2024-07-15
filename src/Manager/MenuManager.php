<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Abstracts\Menus;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\MenuGroup;

class MenuManager extends Menus
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

    public function __construct()
    {
    }

    /**
     * @param array|string|null $name
     * @param array|string|null $group
     * @return MenuCollection
     */
    public static function get(null|array|string $name = null, null|array|string $group = null): MenuCollection
    {
        if (static::$menus instanceof MenuCollection) {
            return static::$menus
                ->when(!empty($name), function (MenuCollection $query) use ($name) {
                    if (is_string($name)) {
                        return $query->where('name', '=', $name);
                    }
                    if (is_array($name)) {
                        return $query->whereIn('name', $name);
                    }
                    return $query;
                })->when(!empty($group), function (MenuCollection $query) use ($group) {
                    if (is_string($group)) {
                        return $query->where('group', '=', $group);
                    }
                    if (is_array($group)) {
                        return $query->whereIn('group', $group);
                    }
                    return $query;
                });
        }
        return new MenuCollection();
    }

    public static function getGroup(string $name, string $group): MenuGroup
    {
        return static::$menus
            ->where(key: 'name', operator: '=', value: $name)
            ->where(key: 'group', operator: '=', value: $group)
            ->first();
    }

    /**
     * @param string|null $name
     * @param string|null $group
     * @param string|null $icon
     * @param callable|null $menus
     * @return $this
     */
    public static function setGroup(?string $name = null, ?string $group = null, ?string $icon = null, callable $menus = null): static
    {
        static::$menus = static::getFactory();
        static::$menus->add(new MenuGroup(name: $name, group: $group, icon: $icon));

        if ($menus) {
            $currentGroup = static::getGroup(name: $name, group: $group);
            $menus = $menus(new AddMenu(menu: $currentGroup));
            /** @var AddMenu $menus */
            $menus->allMenus()->each(function ($menu) use ($currentGroup) {
                $currentGroup->menus->add(item: $menu);
            });
        }

        return new static();
    }
}
