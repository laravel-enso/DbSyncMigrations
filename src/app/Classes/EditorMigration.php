<?php

namespace LaravelEnso\DbSyncMigrations\app\Classes;

use Illuminate\Database\Eloquent\Model;

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
        $to = str_replace('.', '_', $this->to->name);
        $stripped = preg_replace("/[^\w]+/", '', $to);
        $this->migrationClass =
            $this->action.studly_case($stripped).class_basename($this->modelClass);
    }

    protected function getReplaceArray()
    {
        $from = $this->convertToString($this->from);

        $to = $this->convertToString(
            $this->getStrippedModelArray(
                $this->to->toArray()
            )
        );

        return [
            'MigrationClass' => $this->migrationClass,
            'ModelClass' => $this->modelClass,
            'private $from = null' => 'private $from = '.$from,
            'private $to = null' => 'private $to = '.$to,
        ];
    }
}
