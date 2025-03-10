<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\TaskService;

class TaskObserver
{
    /**
     * Преимущества:
     * Теперь не нужно вызывать метод вручную, он выполняется автоматически при изменении модели.
     */

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    
    /**  
     * Handle the Task "updated" event.  
     *  
     * @param  \App\Models\Task  $task  
     * @return void  
     */
    public function updated(Task $task)
    {
        // Проверяем, изменился ли статус  
        if ($task->isDirty('status')) {
            $oldStatus = $task->getOriginal('status');
            $this->taskService->notifyUsersAboutTaskStatusChange($oldStatus, $task);
        }
    }
}
