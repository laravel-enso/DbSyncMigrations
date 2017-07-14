<?php

namespace LaravelEnso\DbSyncMigrations\app\Traits;

use LaravelEnso\DbSyncMigrations\app\Classes\CreatorMigration;
use LaravelEnso\DbSyncMigrations\app\Classes\DestroyerMigration;
use LaravelEnso\DbSyncMigrations\app\Classes\EditorMigration;

trait DbSyncMigrations
{
    protected static function bootDbSyncMigrations()
    {
        if (config('app.env') == 'testing') {
            return false;
        }

        self::created(function ($model) {
            (new CreatorMigration(self::class, $model))
                ->build();
        });

        self::updated(function ($model) {
            (new EditorMigration(self::class, $model->getOriginal(), $model))
                ->build();
        });

        self::deleted(function ($model) {
            (new DestroyerMigration(self::class, $model))
                ->build();
        });
    }
}
