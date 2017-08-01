<?php

namespace LaravelEnso\DbSyncMigrations;

use Illuminate\Support\ServiceProvider;

class DbSyncServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'dbsync-config');

        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'enso-config');

        $this->mergeConfigFrom(__DIR__.'/config/dbsync.php', 'dbsync');
    }

    public function register()
    {
        //
    }
}
