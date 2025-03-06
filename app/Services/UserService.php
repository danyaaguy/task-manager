<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;

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

    public function assignRole($roleId, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        $user->roles()->attach($role);
    }
}
