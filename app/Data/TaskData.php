<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use App\States\Task\Assigned;
use Spatie\LaravelData\Optional;

class TaskData extends Data
{
    public function __construct(
        public string|Optional $title,
        public string|Optional $description = '',
        public string|Optional $state = Assigned::class,
    ) {}
}
