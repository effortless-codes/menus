<?php

namespace Winata\Menu\Object;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;

/**
 * Class Menu
 *
 * Represents a single menu item, which may contain nested submenus.
 * It supports dynamic visibility via a resolver and handles active route detection.
 *
 * @package Winata\Menu\Object
 */
class Menu implements HasMenu
{
    /**
     * The route name used for navigation.
     *
     * @var string|null
     */
    public ?string $routeName;

    /**
     * The menu display title.
     *
     * @var string|null
     */
    public ?string $title;

    /**
     * The route name used to determine active state.
     *
     * @var string|null
     */
    public ?string $activeRouteName;

    /**
     * The icon used for the menu item (optional).
     *
     * @var string|null
     */
    public ?string $icon;

    /**
     * A closure or boolean that determines if this menu item should be shown.
     *
     * @var Closure|bool
     */
    public Closure|bool $resolver;

    /**
     * The type of the menu, usually route-based.
     *
     * @var MenuType
     */
    public MenuType $menuType;

    /**
     * A collection of child menu items.
     *
     * @var MenuCollection<Menu>
     */
    public MenuCollection $menus;

    /**
     * Menu constructor.
     *
     * @param string|null $routeName
     * @param string|null $title
     * @param string|null $activeRouteName
     * @param string|null $icon
     * @param Closure|bool|null $resolver
     * @param MenuType|null $menuType
     * @param MenuCollection|null $menus
     */
    public function __construct(
        ?string $routeName = null,
        ?string $title = 'menu',
        ?string $activeRouteName = null,
        ?string $icon = null,
        Closure|bool $resolver = true,
        ?MenuType $menuType = null,
        ?MenuCollection $menus = null,
    ) {
        $this->routeName = $routeName;
        $this->title = $title;
        $this->activeRouteName = $activeRouteName;
        $this->icon = $icon;
        $this->resolver = $resolver;
        $this->menuType = $menuType ?? MenuType::ROUTE;
        $this->menus = $menus ?? new MenuCollection();

        $this->resolve();
    }

    /**
     * Resolves the menu's visibility condition.
     *
     * @return bool
     */
    public function resolve(): bool
    {
        if ($this->resolver instanceof Closure) {
            $this->resolver = (bool) $this->resolver->call($this);
        }

        return $this->resolver;
    }

    /**
     * Determines whether this menu item is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        if ($this->menuType === MenuType::ROUTE) {
            return $this->isActiveRoute($this->activeRouteName ?? $this->routeName);
        }

        return false;
    }

    /**
     * Determines whether the given route is currently active, including optional parameter matching.
     *
     * @param string $route
     * @param array $params
     * @return bool
     */
    private function isActiveRoute(string $route = '', array $params = []): bool
    {
        $route = str($route)->trim();

        if ($route->isEmpty()) {
            return false;
        }

        try {
            $routeName = $route->toString();

            if (!request()->routeIs($routeName, "{$routeName}.*")) {
                return false;
            }

            if (empty($params)) {
                return true;
            }

            $currentRoute = request()->route();
            $paramNames = $currentRoute->parameterNames();

            foreach ($params as $key => $value) {
                if (is_int($key)) {
                    $key = $paramNames[$key] ?? null;
                }

                if (!$key) {
                    return false;
                }

                $param = $currentRoute->parameter($key);

                // If both are Eloquent models, compare their primary keys
                if ($param instanceof Model && $value instanceof Model) {
                    if ($param->getKey() !== $value->getKey()) {
                        return false;
                    }
                    continue;
                }

                // If object, try to compare `value` property (e.g. for enums)
                if (is_object($param)) {
                    try {
                        if (property_exists($param, 'value') && $param->value !== $value) {
                            return false;
                        }
                    } catch (Exception) {
                        return false;
                    }
                } else {
                    if ($param !== $value) {
                        return false;
                    }
                }
            }

            return true;
        } catch (Exception) {
            return false;
        }
    }
}
