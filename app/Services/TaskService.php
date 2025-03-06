<?php

namespace App\Services;

use App\Models\Task;
use App\Notifications\TaskStatusChanged;

class TaskService
{
    /**
     * Get all tasks with optional filters and sorting.
     * 
     * @param array $filters
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @return \Illuminate\Database\Eloquent\Collection|Task[]
     */
    public function getTasks($filters, $sortBy, $sortDirection)
    {
        $query = Task::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Отрезок даты
        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection ?: 'asc');
        }

        return $query->get();
    }

    /**
     * Notify the users about task status change.
     * 
     * @param int $oldStatus
     * @param \App\Models\Task $task
     */
    public function statusNotification($oldStatus, $task)
    {
        // 1 для "В работе", 2 для "Выполнена"
        if ($oldStatus !== $task->status && in_array($task->status, [1, 2])) {
            foreach ($task->users as $user) {
                $user->notify(new TaskStatusChanged($task->id, $task->status));
            }
        }
    }
}
