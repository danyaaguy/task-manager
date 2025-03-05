<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Jobs\AssignTask;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::with('user')->get();
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
        $task->update($request->validate([
            'title' => 'string',
            'description' => 'nullable|string'
        ]));
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
