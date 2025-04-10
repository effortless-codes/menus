<?php

namespace Winata\Menu\Contracts;

/**
 * Interface MenuItem
 *
 * Represents an individual menu item with visibility and active state logic.
 *
 * @package Winata\Menu\Contracts
 */
interface MenuItem
{
    /**
     * Determine if the menu item should be displayed.
     *
     * @return bool
     */
    public function resolve(): bool;

    /**
     * Determine if the menu item is currently active.
     *
     * @return bool
     */
    public function isActive(): bool;
}
