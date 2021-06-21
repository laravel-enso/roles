<?php

namespace LaravelEnso\Roles;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Roles\Commands\Sync;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->publish()
            ->commands(Sync::class);
    }

    private function load()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/roles.php', 'enso.roles');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path('enso'),
        ], ['roles-config', 'enso-config']);

        $this->publishes([
            __DIR__.'/../database/factories' => database_path('factories'),
        ], ['roles-factory', 'enso-factories']);

        $this->publishes([
            __DIR__.'/../database/seeds' => database_path('seeds'),
        ], ['roles-seeder', 'enso-seeders']);

        return $this;
    }
}
