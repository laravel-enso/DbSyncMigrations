<?php

namespace LaravelEnso\DbSyncMigrations;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'dbsync-config');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');

        $this->mergeConfigFrom(__DIR__.'/config/dbsync.php', 'enso.dbsync');
    }

    public function register()
    {
        //
    }
}
