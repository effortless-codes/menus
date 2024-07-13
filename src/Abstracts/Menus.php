<?php

namespace Winata\Menu\Abstracts;

use Illuminate\Support\Fluent;
use Winata\Menu\MenuCollection;

abstract class Menus
{

    protected ?MenuCollection $menus = null;

    /**
     * @return MenuCollection
     */
    protected function getFactory(): MenuCollection
    {
        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
        return $this->menus;
    }
}
