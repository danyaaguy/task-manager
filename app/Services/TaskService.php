<?php

namespace App\Services;

use App\States\Task\Progress;
use App\States\Task\Completed;
use App\Notifications\TaskStatusChanged;

class TaskService
{
    /**
     * Notify the users about task status change.
     *
     * @param int $oldStatus
     * @param \App\Models\Task $task
     */
    public function notifyUsersAboutTaskStatusChange($oldStatus, $task)
    {
        if ($oldStatus !== $task->status && in_array($task->state, [Progress::class, Completed::class])) {
            $task->users->each(function ($user) use ($task) {
                $user->notify(new TaskStatusChanged($task->id, $task->status));
            });
        }
    }
}
