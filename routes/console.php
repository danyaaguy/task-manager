<?php

use App\Console\Commands\AssignTasksCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(AssignTasksCommand::class)->everyFiveMinutes();