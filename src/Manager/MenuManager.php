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
     * @return MenuCollection
     */
    public static function get(): MenuCollection
    {
        if (static::$menus instanceof MenuCollection){
            return static::$menus->groupBy('group');
        }
        return new MenuCollection();
    }

    public static function getGroup(string $group): MenuGroup
    {
        return static::$menus->where('group', $group)->first();
    }

    /**
     * @param string|null $name
     * @param string|null $group
     * @return $this
     */
    public static function setGroup(string $name = null, string $group = null, callable $menus = null): static
    {
        static::$menus = static::getFactory();
        static::$menus->add(new MenuGroup($name, $group));

        $currentGroup = static::getGroup($group);

        if ($menus) {
            $menus = $menus(new AddMenu($currentGroup));
            /** @var AddMenu $menus */
            $menus->allMenus()->each(function ($menu) use ($currentGroup) {
                $currentGroup->menus->add($menu);
            });
        }

        return new static();
    }
}
