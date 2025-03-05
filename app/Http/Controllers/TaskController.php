<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

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
        $task = Task::create($request->validate(['title' => 'required', 'description' => 'nullable|string', 'assigned_to' => 'nullable|exists:users,id']));
        return response()->json($task, 201);
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
     * @param Task $task
     * @return JsonResponse
     */
    public function unassign(Request $request, Task $task): JsonResponse
    {
        $task->update(['assigned_to' => null]);
        return response()->json($task);
    }
}
