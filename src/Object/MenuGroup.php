<?php

namespace Winata\Menu\Object;

use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\MenuCollection;

class MenuGroup implements HasMenu
{
    public ?string $name = 'default';
    public ?string $group = 'default';
    public ?string $icon = null;
    public ?MenuCollection $menus = null;

    public function __construct(
        ?string $name = 'default',
        ?string $group = 'default',
        ?string $icon = null,
    )
    {
        $this->setName($name);
        $this->setGroup($group);
        $this->setIcon($icon);

        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name = null): void
    {
        $this->name = $name;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(?string $group = null): void
    {
        $this->group = $group;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon = null): void
    {
        $this->icon = $icon;
    }
}
