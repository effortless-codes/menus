<?php

namespace Winata\Menu\Object;

use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\MenuCollection;

class MenuGroup implements HasMenu
{
    public string $name = 'default';
    public string $group = 'default';
    public ?MenuCollection $menus = null;

    public function __construct(
        string $name = 'default',
        string $group = 'default',
    )
    {
        $this->setName($name);
        $this->setGroup($group);

        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): void
    {
        $this->group = $group;
    }
}
