<?php

namespace Winata\Menu\Enums;

/**
 * Enum MenuType
 *
 * Represents the available types of menu items.
 *
 * @package Winata\Menu\Enums
 */
enum MenuType: string
{
    /**
     * Menu item linked to a named route.
     */
    case ROUTE = 'route';

    /**
     * Menu item linked to a direct URL.
     */
    case URL = 'url';
}
