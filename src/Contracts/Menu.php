<?php

namespace Winata\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;
use Winata\Menu\Enums\MenuType;

/**
 * Interface Menu
 *
 * Defines the structure and behavior for building application menus dynamically.
 *
 * @package Winata\Menu\Contracts
 */
interface Menu
{
    /**
     * Retrieve all registered menus.
     *
     * @return Collection
     */
    public function get(): Collection;

    /**
     * Add a new route-based menu item.
     *
     * @param string $name          Unique identifier for the menu.
     * @param string $title         Display title of the menu.
     * @param array  $attribute     Optional HTML attributes for the menu link.
     * @param array  $param         Optional parameters for the route.
     * @param string|null $activeRoute      The route name to match for active state (optional).
     * @param array|null  $activeRouteParam The parameters to match with the route for active state (optional).
     * @param Closure|bool $resolver        A callback or boolean that determines visibility (optional).
     *
     * @return static
     */
    public static function route(
        string $name,
        string $title,
        array $attribute = [],
        array $param = [],
        ?string $activeRoute = null,
        ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;

    /**
     * Add a new URL-based menu item.
     *
     * @param string $name          Unique identifier for the menu.
     * @param string $title         Display title of the menu.
     * @param array  $attribute     Optional HTML attributes for the menu link.
     * @param array  $param         Optional query parameters for the URL.
     * @param string|null $activeRoute      The route name to match for active state (optional).
     * @param array|null  $activeRouteParam The parameters to match with the route for active state (optional).
     * @param Closure|bool $resolver        A callback or boolean that determines visibility (optional).
     *
     * @return static
     */
    public static function url(
        string $name,
        string $title,
        array $attribute = [],
        array $param = [],
        ?string $activeRoute = null,
        ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;

    /**
     * General method to add a new menu item.
     *
     * @param MenuType $type        The type of the menu (route or url).
     * @param string $name          Unique identifier for the menu.
     * @param string $title         Display title of the menu.
     * @param array  $attribute     Optional HTML attributes for the menu link.
     * @param array  $param         Optional parameters for route or URL.
     * @param string|null $activeRoute      The route name to match for active state (optional).
     * @param array|null  $activeRouteParam The parameters to match with the route for active state (optional).
     * @param Closure|bool $resolver        A callback or boolean that determines visibility (optional).
     *
     * @return static
     */
    public static function add(
        MenuType $type,
        string $name,
        string $title,
        array $attribute = [],
        array $param = [],
        ?string $activeRoute = null,
        ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;
}
