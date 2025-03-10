<?php

namespace App\States\Task;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class TaskState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Assigned::class)
            ->allowTransition(Assigned::class, Progress::class)
            ->allowTransition(Progress::class, Completed::class)
        ;
    }
}