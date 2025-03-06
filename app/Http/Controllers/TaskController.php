<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AssignTask;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) {}

    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'integer|in:0,1,2',
            'sort_by' => 'string',
            'sort_direction' => 'string|in:asc,desc',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        $filters = [
            'status' => $request->input('status'),
        ];

        $sortBy = $request->input('sort_by');
        $sortDirection = $request->input('sort_direction', 'asc');

        $tasks = $this->taskService->getTasks($filters, $sortBy, $sortDirection);

        return response()->json($tasks, 200);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([  
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Задание на назначение свободного сотрудника через 5 минут (300 секунд)  
        AssignTask::dispatch($task)->delay(now()->addMinutes(5));

        return response()->json(['task' => $task, 'message' => 'Задача успешно создана.'], 201);
    }

    /**
     * Update the specified task.
     * 
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $data = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'status' => 'integer|in:0,1,2',
        ]);

        $task->update($data);
        return response()->json($task, 200);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json(null, 200);
    }

    /**
     * Assign a task to a user.
     * 
     * @param Request $request
     * @param int $taskId
     * @param int $userId
     * @return JsonResponse
     */
    public function assign(Request $request, $taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->attach($userId);

        return response()->json($task->load('users'), 200);
    }

    /**
     * Unassign a task from a user.
     * 
     * @param Request $request
     * @param int $taskId
     * @param int $userId
     * @return JsonResponse
     */
    public function unassign(Request $request, $taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->detach($userId);

        return response()->json($task->load('users'), 200);
    }
}
