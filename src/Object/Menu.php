<?php

namespace Winata\Menu\Object;

use Winata\Menu\Contracts\HasMenu;
use Winata\Menu\MenuCollection;

class Menu implements HasMenu
{
    public string $name;
    public string $title;
    public string $url;
    public ?MenuCollection $menus = null;


    public function __construct(
        string $title = 'default',
        string $url = '#',
    )
    {
        $this->name = $title;
        $this->setTitle($title);
        $this->setUrl($url);
        if (!$this->menus instanceof MenuCollection) {
            $this->menus = new MenuCollection();
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
