<?php

namespace App\Data;

use App\States\User\Work;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserData extends Data
{
    public function __construct(
        public string|Optional $name,
        public string|Optional $email,
        public string|Optional $state = Work::class,
        public string|Optional $password,
    ) {}
}
