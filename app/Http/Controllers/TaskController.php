<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ApiResource;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Data\TaskData;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::with('users')->filter()->sort()->get();

        return ApiResource::success(TaskResource::collection($tasks), 200);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param Request $request
     * @param TaskData $taskData
     * @param StoreTaskRequest $storeTaskRequest
     * @return JsonResponse
     */
    public function store(Request $request, TaskData $taskData, StoreTaskRequest $storeTaskRequest): JsonResponse
    {
        $validatedData = $storeTaskRequest->validated();

        $data = $taskData->from($validatedData);

        $task = Task::create($data->toArray());

        return ApiResource::success(new TaskResource($task), 201);
    }

    /**
     * Update the specified task.
     *
     * @param Request $request
     * @param Task $task
     * @param TaskData $taskData
     * @param UpdateTaskRequest $updateTaskRequest
     * @return JsonResponse
     */
    public function update(Request $request, Task $task, TaskData $taskData, UpdateTaskRequest $updateTaskRequest): JsonResponse
    {
        $validatedData = $updateTaskRequest->validated();

        $data = $taskData->from($validatedData);

        $task->update($data->toArray());

        return ApiResource::success(new TaskResource($task), 200);
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

        return ApiResource::success(null, 200);
    }
}
