<?php

namespace Winata\Menu;

use Illuminate\Support\ServiceProvider;
use Winata\Menu\Manager\MenuManager;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->singleton('menus', fn ($app, $p) => new MenuManager());
        $this->app->alias('menus', MenuManager::class);
    }
}
