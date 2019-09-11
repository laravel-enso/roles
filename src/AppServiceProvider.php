<?php

namespace LaravelEnso\Roles;

use LaravelEnso\Roles\app\Enums\Roles;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Roles\app\Commands\Sync;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands(Sync::class);

        $this->load()
            ->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'roles-factory');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'enso-factories');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'roles-seeder');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'enso-seeders');
    }
}
