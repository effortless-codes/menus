<?php

namespace Winata\Menu\Manager;

use Winata\Menu\Abstracts\Menus;
use Winata\Menu\Contracts\Menu;
use Winata\Menu\MenuCollection;
use Winata\Menu\Object\MenuGroup;

class MenuManager extends Menus
{

    public function __construct()
    {
        $this->menus = $this->getFactory();
    }

    /**
     * @return MenuCollection
     */
    public function get(): MenuCollection
    {
        return $this->menus->groupBy('name');
    }

    public function getGroup(string $group): MenuGroup
    {
        return $this->menus->where('group', $group)->first();
    }

    /**
     * @param string|null $name
     * @param string|null $group
     * @return $this
     */
    public function setGroup(string $name = null, string $group = null, callable $menus = null): static
    {
        $this->menus->add(new MenuGroup($name, $group));

        $currentGroup = $this->getGroup($group);

        if ($menus) {
            $menus = $menus(new AddMenu($currentGroup));
            /** @var AddMenu $menus */
            $menus->allMenus()->each(function ($menu) use ($currentGroup) {
                $currentGroup->menus->add($menu);
            });
        }

        return $this;
    }
}
