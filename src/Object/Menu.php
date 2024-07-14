<?php

namespace Winata\Menu\Object;

use Exception;
use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\Enums\MenuType;
use Winata\Menu\MenuCollection;


/**
 * @property string $routeName
 * @property string $title
 * @property string $activeRouteName
 * @property MenuCollection<Menu> $menus
 * @property string $icon
 * @property \Closure|bool $resolver
 * @property MenuType $menuType
 * */
class Menu implements HasMenu
{

    public function __construct(
        public string          $group,
        public ?string         $routeName = null,
        public ?string         $title = 'menu',
        public ?string         $activeRouteName = null,
        public ?string         $icon = null,
        public \Closure|bool   $resolver = true,
        public MenuType        $menuType = MenuType::ROUTE,
        public ?MenuCollection $menus = null,
    )
    {
        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
        $this->resolve();
    }

    public function resolve(): bool
    {
        if ($this->resolver instanceof \Closure) {
            $this->resolver = (bool)$this->resolver->call($this);
        }

        return $this->resolver;
    }

    public function isActive(): bool
    {
        if ($this->menuType == MenuType::ROUTE) {
            return $this->isActiveRoute($this->activeRouteName ?? $this->routeName);
        }

        return false;
    }

    private function isActiveRoute(string $route = '', array $params = []): bool
    {
        $route = str($route)->trim();
        if ($route->isEmpty()) {
            return false;
        }

        try {
            $route = $route->toString();
            if (request()->routeIs($route, "{$route}.*")) {
                if (empty($params)) {
                    return true;
                }

                $requestRoute = request()->route();
                $paramNames = $requestRoute->parameterNames();

                foreach ($params as $key => $value) {
                    if (is_int($key)) {
                        $key = $paramNames[$key];
                    }

                    if (
                        $requestRoute->parameter($key) instanceof \Illuminate\Database\Eloquent\Model
                        && $value instanceof \Illuminate\Database\Eloquent\Model
                        && $requestRoute->parameter($key)->id != ($value->id ?? null)
                    ) {
                        return false;
                    }

                    if (is_object($requestRoute->parameter($key))) {
                        // try to check param is enum type
                        try {
                            if ($requestRoute->parameter($key)->value && $requestRoute->parameter($key)->value != $value) {
                                return false;
                            }
                        } catch (Exception $e) {
                            return false;
                        }
                    } else {
                        if ($requestRoute->parameter($key) != $value) {
                            return false;
                        }
                    }
                }

                return true;
            }
        } catch (Exception $e) {
        }

        return false;
    }

}
