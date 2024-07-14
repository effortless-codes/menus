<?php

use Winata\Menu\Manager\MenuManager;

if (! function_exists('menus')) {
    /**
     * @return MenuManager
     */
    function menus(): MenuManager
    {
        return new MenuManager();
    }
}
