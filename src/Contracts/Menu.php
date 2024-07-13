<?php

namespace Winata\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;
use Winata\Menu\Enums\MenuType;

interface Menu
{
    public function get(): Collection;

    public static function route(
        string $name, string $title, array $attribute = [], array $param = [],
        ?string $activeRoute = null, ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;

    public static function url(
        string $name, string $title, array $attribute = [], array $param = [],
        ?string $activeRoute = null, ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;

    public static function add(
        MenuType $type, string $name, string $title, array $attribute = [], array $param = [],
        ?string $activeRoute = null, ?array $activeRouteParam = null,
        Closure|bool $resolver = true
    ): static;
}
