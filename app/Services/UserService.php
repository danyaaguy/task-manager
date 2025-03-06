<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;

class UserService
{
    /**
     * Get all users with optional filters and sorting.
     * 
     * @param array $filters
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
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

    /**
     * Assign a role to a user.
     * 
     * @param int $roleId
     * @param int $userId
     * @return void
     */
    public function assignRole($roleId, $userId)
    {
        $user = User::findOrFail($userId);
        $role = Role::findOrFail($roleId);

        $user->roles()->attach($role);
    }
}
