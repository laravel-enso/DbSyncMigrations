<!--h-->
# DB Sync Migrations
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/fa51ab87e577427db9efb0ede1ef9cb0)](https://www.codacy.com/app/laravel-enso/DbSyncMigrations?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/DbSyncMigrations&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://styleci.io/repos/97226775/shield?branch=master)](https://styleci.io/repos/97226775)
[![License](https://poser.pugx.org/laravel-enso/dbsyncmigrations/license)](https://https://packagist.org/packages/laravel-enso/dbsyncmigrations)
[![Total Downloads](https://poser.pugx.org/laravel-enso/dbsyncmigrations/downloads)](https://packagist.org/packages/laravel-enso/dbsyncmigrations)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/dbsyncmigrations/version)](https://packagist.org/packages/laravel-enso/dbsyncmigrations)
<!--/h-->

Adds the ability to easily sync your model's DB states between development and production

### Details

By adding the `DbSyncMigrations` trait to your models, you'll have atomatically generated migrations for the changes you make to your models.

You may globally disable the migration creation by editing the `dbsync.php` config file and setting `dbsync` to false

### Notes

The [Laravel Enso Core](https://github.com/laravel-enso/Core) package comes with this package included.

### Publishes
- `php artisan vendor:publish --tag=dbsync-config` - configuration file
- `php artisan vendor:publish --tag=enso-config` - a common alias for when wanting to update the config,
once a newer version is released

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h-->