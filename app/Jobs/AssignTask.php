<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Task;
use App\Models\User;

class AssignTask implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Проверяем, была ли задача уже назначена  
        if ($this->task->users()->exists()) {
            return;
        }

        // Назначаем задачу свободному сотруднику 
        $freeUser = User::doesntHave('tasks')->first();
        
        if ($freeUser) {
            $this->task->users()->attach($freeUser->id);
        }
    }
}
