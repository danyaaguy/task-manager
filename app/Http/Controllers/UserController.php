<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
    ) {}

    /**
     * Display a listing of the users.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'integer|in:0,1',
            'sort_by' => 'string',
            'sort_direction' => 'string|in:asc,desc',
        ]);

        $filters = [
            'status' => $request->input('status'),
        ];

        $sortBy = $request->input('sort_by');
        $sortDirection = $request->input('sort_direction', 'asc');

        $users = $this->userService->getUsers($filters, $sortBy, $sortDirection);

        return response()->json($users, 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'status' => 'integer|in:0,1',
        ]);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users',
            'password' => 'string|min:8',
            'status' => 'integer|in:0,1',
        ]);
        $user->update($data);
        return response()->json($user, 200);
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
        return response()->json(null, 200);
    }
}
