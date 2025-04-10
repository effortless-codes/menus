<?php

use Winata\Menu\Manager\MenuManager;

if (! function_exists('menus')) {
    /**
     * Get the singleton instance of MenuManager.
     *
     * @return MenuManager
     * @package Winata\Menu\Helpers
     */
    function menus(): MenuManager
    {
        return app(MenuManager::class);
    }
}

