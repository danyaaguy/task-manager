<?php

namespace App\States\User;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class UserState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Work::class)
            ->allowTransition(Work::class, Vacation::class)
            ->allowTransition(Vacation::class, Work::class)
        ;
    }
}