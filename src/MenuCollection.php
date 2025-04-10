<?php

namespace Winata\Menu;

use Illuminate\Support\Collection;
use Winata\Menu\Object\Menu;

/**
 * Class MenuCollection
 *
 * Represents a collection of Menu items.
 *
 * This class extends Laravel's base Collection, allowing full usage
 * of Collection methods (e.g., filter, map, reduce), and may be extended
 * with custom menu-specific logic.
 *
 * @package Winata\Menu
 *
 * @method Menu|null first(callable $callback = null, $default = null)
 * @method Menu|null last(callable $callback = null, $default = null)
 * @method Menu|null get($key, $default = null)
 * @method MenuCollection filter(callable $callback = null)
 * @method MenuCollection map(callable $callback)
 * @method MenuCollection sortBy($callback, $options = SORT_REGULAR, $descending = false)
 */
class MenuCollection extends Collection
{
    //
}
