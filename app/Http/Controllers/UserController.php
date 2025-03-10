<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\ApiResource;
use App\Data\UserData;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Преимущества:
     * Теперь при тестировании контроллера не придётся мокировать или создавать заглушки
     * Контроллер освобождается от логики валидации, фильтрации и сортировки.
     * Правила валидации можно использовать в нескольких контроллерах.
     */

    /**
     * Display a listing of the users.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::with(['tasks', 'roles'])->filter()->sort()->get();

        return ApiResource::success(UserResource::collection($users), 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @param UserData $userData
     * @param StoreUserRequest $storeUserRequest
     * @return JsonResponse
     */
    public function store(Request $request, UserData $userData, StoreUserRequest $storeUserRequest): JsonResponse
    {
        $validatedData = $storeUserRequest->validated();

        $data = $userData->from($validatedData);

        $user = User::create($data->toArray());

        return ApiResource::success(new UserResource($user), 201);
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param User $user
     * @param UserData $userData
     * @param UpdateUserRequest $updateUserRequest
     * @return JsonResponse
     */
    public function update(Request $request, User $user, UserData $userData, UpdateUserRequest $updateUserRequest): JsonResponse
    {
        $validatedData = $updateUserRequest->validated();

        $data = $userData->from($validatedData);

        $user->update($data->toArray());

        return ApiResource::success(new UserResource($user), 200);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return ApiResource::success(null, 200);
    }
}
