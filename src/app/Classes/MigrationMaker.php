<?php

namespace LaravelEnso\DbSyncMigrations\app\Classes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class MigrationMaker
{
    protected $modelClass = null;
    protected $migrationClass = null;
    protected $migrationName = null;
    protected $action = null;

    public function __construct(string $modelClass, Model $model)
    {
        $this->modelClass = $modelClass;
        $this->model = $model;
    }

    public function build()
    {
        $this->setMigrationClassName();
        $this->adjustNameIfMigrationExists();
        $this->setMigrationName();
        $this->writeMigration();
        $this->insertMigration();
    }

    protected function setMigrationClassName()
    {
        $modelName = str_replace('.', '_', $this->model->name);
        $stripped = preg_replace("/[^\w]+/", '', $modelName);

        $this->migrationClass =
            $this->action.studly_case($stripped).class_basename($this->modelClass);
    }

    protected function adjustNameIfMigrationExists()
    {
        $existingMigrations = $this->getExistingMigrations();

        while (in_array(snake_case($this->migrationClass), $existingMigrations)) {
            $this->migrationClass .= 'X';
        }
    }

    protected function getExistingMigrations()
    {
        $migrations = \File::files(database_path('migrations'));

        foreach ($migrations as &$migration) {
            $filePath = $migration->getRealPath();
            $array = explode('/', $filePath);
            $migration = substr(array_pop($array), 18, -4);
        }

        return $migrations;
    }

    protected function setMigrationName()
    {
        $this->migrationName =
            Carbon::now()->format('Y_m_d_His').'_'.snake_case($this->migrationClass).'.php';
    }

    protected function writeMigration()
    {
        $migration = $this->populateStub();
        $path = database_path('migrations').DIRECTORY_SEPARATOR.$this->migrationName;
        \File::put($path, $migration);
    }

    protected function populateStub()
    {
        $replace = $this->getReplaceArray();
        $stub = $this->readStub();

        return str_replace(array_keys($replace), array_values($replace), $stub);
    }

    protected function getReplaceArray()
    {
        $modelString = $this->convertToString($this->getStrippedModelArray($this->model->toArray()));

        return [
            'MigrationClass' => $this->migrationClass,
            'ModelClass' => $this->modelClass,
            'private $model = null' => 'private $model = '.$modelString,
        ];
    }

    protected function getStrippedModelArray(array $array)
    {
        unset($array['created_at'], $array['updated_at']);

        return $array;
    }

    protected function convertToString(array $array)
    {
        return $this->formatArrayString(var_export($array, true));
    }

    protected function formatArrayString(string $string)
    {
        $from = ['array (', '), '.PHP_EOL, '  '];
        $to = ['[', '], '.PHP_EOL, '        '];

        $string = str_replace($from, $to, $string);
        $string = substr($string, 0, -2).PHP_EOL.'    ]';

        return $string;
    }

    protected function readStub()
    {
        return \File::get(__DIR__.'/../../stubs/'.strtolower($this->action).'.stub');
    }

    protected function insertMigration()
    {
        $batch = \DB::table('migrations')
            ->orderByDesc('batch')
            ->first(['batch'])
            ->batch;

        \DB::table('migrations')->insert([
                'migration' => substr($this->migrationName, 0, -4),
                'batch' => $batch + 1,
            ]);
    }
}
