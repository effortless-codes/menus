<?php

namespace Winata\Menu\Contracts;

interface MenuItem
{
    public function resolve(): bool;

    public function isActive(): bool;
}
