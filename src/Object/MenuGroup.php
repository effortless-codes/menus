<?php

namespace Winata\Menu\Object;

use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\MenuCollection;

/**
 * Class MenuGroup
 *
 * Represents a group of menus with a shared name, group identifier, and icon.
 *
 * @package Winata\Menu\Object
 */
class MenuGroup implements HasMenu
{
    /**
     * The name of the menu group.
     *
     * @var string|null
     */
    public ?string $name = 'default';

    /**
     * The group identifier (can be used for grouping or permissions).
     *
     * @var string|null
     */
    public ?string $group = 'default';

    /**
     * Optional icon for the group.
     *
     * @var string|null
     */
    public ?string $icon = null;

    /**
     * Collection of menus inside this group.
     *
     * @var MenuCollection
     */
    public MenuCollection $menus;

    /**
     * MenuGroup constructor.
     *
     * @param string|null $name
     * @param string|null $group
     * @param string|null $icon
     */
    public function __construct(
        ?string $name = 'default',
        ?string $group = 'default',
        ?string $icon = null,
    ) {
        $this->name = $name;
        $this->group = $group;
        $this->icon = $icon;
        $this->menus = new MenuCollection();
    }

    /**
     * Get the name of the menu group.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? 'default';
    }

    /**
     * Set the name of the menu group.
     *
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name = null): void
    {
        $this->name = $name;
    }

    /**
     * Get the group identifier.
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group ?? 'default';
    }

    /**
     * Set the group identifier.
     *
     * @param string|null $group
     * @return void
     */
    public function setGroup(?string $group = null): void
    {
        $this->group = $group;
    }

    /**
     * Get the group icon.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon ?? '';
    }

    /**
     * Set the icon of the menu group.
     *
     * @param string|null $icon
     * @return void
     */
    public function setIcon(?string $icon = null): void
    {
        $this->icon = $icon;
    }
}
