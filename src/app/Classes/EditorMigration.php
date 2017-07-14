<?php

namespace LaravelEnso\ModelTrackingMigrations\app\Classes;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\ModelTrackingMigrations\app\Classes\MigrationMaker;

class EditorMigration extends MigrationMaker
{
    protected $from = null;
    protected $to = null;
    protected $action = 'Edit';

    public function __construct(string $modelClass, array $from, Model $to)
    {
        $this->modelClass = $modelClass;
        $this->from = $from;
        $this->to = $to;
    }

    protected function setMigrationClassName()
    {
        $this->migrationClass =
            $this->action.studly_case($this->to->name).class_basename($this->modelClass);
    }

    protected function getReplaceArray()
    {
        $from = $this->convertToString($this->from);
        $to = $this->convertToString($this->getStrippedModelArray($this->to->toArray()));

        return [
            'MigrationClass' => $this->migrationClass,
            'ModelClass' => $this->modelClass,
            'private $from = null' => 'private $from = '.$from,
            'private $to = null' => 'private $to = '.$to,
        ];
    }
}