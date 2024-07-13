<?php

use Winata\Menu\Contracts\Menu;
use Winata\Menu\Enums\MenuType;
use Winata\Menu\Factory;

//if (! function_exists('menus')) {
//    /**
//     * Menu instance.
//     *
//     * @param  ?string $name
//     * @param  ?string $group
//     * @param array $groupAttribute
//     * @return Menu
//     */
//    function menus(?string $name = null, ?string $group = null, array $groupAttribute = []): Menu
//    {
//        return new Factory(name: $name, group: $group, groupAttribute: $groupAttribute);
//    }
//}
//
//if (! function_exists('menuType')) {
//    /**
//     * Menu Type Enum.
//     *
//     * @param  string|null  $type
//     * @return MenuType|string|null
//     */
//    function menuType(?string $type = null): MenuType|string|null
//    {
//        if ($type) {
//            return MenuType::tryFrom($type);
//        }
//
//        return MenuType::class;
//    }
//}
