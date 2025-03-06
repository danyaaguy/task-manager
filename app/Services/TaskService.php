<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getTasks($filters, $sortBy, $sortDirection)
    {
        $query = Task::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection ?: 'asc');
        }

        return $query->get();
    }
}
