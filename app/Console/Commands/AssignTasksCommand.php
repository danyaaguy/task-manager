<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use App\States\Task\Assigned;

class AssignTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tasks assign to free users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Логика нахождения и назначения задач  
        $tasks = Task::whereState('state', Assigned::class);

        foreach ($tasks as $task) {
            // Назначаем задачу свободному сотруднику
            $freeUser = User::doesntHave('tasks')->first();

            // Логика назначения задачи (например, присвоение пользователю)  
            $task->users()->attach($freeUser->id);
            $task->save();
        }

        $this->info('Tasks assigned successfully!');
    }
}
