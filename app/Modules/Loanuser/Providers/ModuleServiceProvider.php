<?php

namespace App\Modules\Loanuser\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'loanuser');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'loanuser');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'loanuser');
        $this->loadConfigsFrom(__DIR__.'/../config');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
