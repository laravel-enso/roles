<?php

namespace LaravelEnso\RoleManager;

use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadDependencies();
        $this->publishesAll();
    }

    private function loadDependencies()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/rolemanager');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function publishesAll()
    {
        $this->publishes([
            __DIR__.'/resources/assets/js/components' => resource_path('assets/js/vendor/laravel-enso/components'),
        ], 'roles-components');

        $this->publishes([
            __DIR__.'/resources/assets/js/components' => resource_path('assets/js/vendor/laravel-enso/components'),
        ], 'update');
    }

    public function register()
    {
        //
    }
}
