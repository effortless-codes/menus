<?php

namespace Winata\Menu;

use Illuminate\Support\ServiceProvider;
use Winata\Menu\Manager\MenuManager;

/**
 * Class MenuServiceProvider
 *
 * This service provider registers the MenuManager singleton into the Laravel service container.
 * You can access the manager via `app('menus')` or by type-hinting `MenuManager`.
 *
 * @package Winata\Menu
 */
class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This method is used to bind classes or functionality into the service container.
     *
     * @return void
     */
    public function register(): void
    {
        // Register services if needed
    }

    /**
     * Bootstrap any application services.
     *
     * This method is called after all other service providers have been registered.
     * It binds the MenuManager class into the service container as a singleton.
     *
     * @return void
     */
    public function boot(): void
    {
        // Register MenuManager as a singleton accessible via 'menus' key or MenuManager::class
        $this->app->singleton('menus', fn ($app) => new MenuManager());

        // Set alias so MenuManager can be resolved via type-hinting
        $this->app->alias('menus', MenuManager::class);
    }
}
