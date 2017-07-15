<?php

namespace LaravelEnso\DbSyncMigrations;

use Illuminate\Support\ServiceProvider;

class DbSyncServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/dbsync.php' => config_path('dbsync.php'),
        ], 'dbsync-config');

        $this->publishes([
            __DIR__.'/config/dbsync.php' => config_path('dbsync.php'),
        ], 'enso-config');

        $this->mergeConfigFrom(__DIR__.'/config/dbsync.php', 'dbsync');
    }

    public function register()
    {
        //
    }
}
