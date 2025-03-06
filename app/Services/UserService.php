<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUsers($filters, $sortBy, $sortDirection)
    {
        $query = User::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection ?: 'asc');
        }

        return $query->get();
    }
}
