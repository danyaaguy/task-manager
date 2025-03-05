<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
        return response()->json($tasks);
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

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'Сотрудник не найден.'], 404);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

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
        $task->update($request->validate(['title' => 'string', 'description' => 'nullable|string', 'assigned_to' => 'nullable|exists:users,id']));
        return response()->json($task);
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
        return response()->json(null, 204);
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

        return response()->json($task->load('users'));
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

        return response()->json($task->load('users')); // Возвращаем обновлённую задачу с пользователями  
    }
}
