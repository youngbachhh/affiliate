<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return ApiResponse::success($users);
        } catch (\Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch users', 500);
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = $this->userService->createUser($validated);

            return ApiResponse::success($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            return ApiResponse::error('Failed to create user', 500);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);

            return ApiResponse::success($user);
        } catch (ModelNotFoundException | Exception $e) {
            Log::error('Failed to fetch user: ' . $e->getMessage());

            return ApiResponse::error('Failed to fetch user', 500);
        }
    }

    public function update(UpdateRequest $request, User $user)
    {
        try {
            $validated = $request->validated();

            $user = $this->userService->updateUser($user, $validated);

            return ApiResponse::success($user, 'User updated successfully');
        } catch (ModelNotFoundException | Exception $e) {
            Log::error('Failed to update user: ' . $e->getMessage());

            return ApiResponse::error('Failed to update user', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);

            return ApiResponse::success(null, 'User deleted successfully');
        } catch (ModelNotFoundException | Exception $e) {
            Log::error('Failed to delete user: ' . $e->getMessage());

            return ApiResponse::error('Failed to delete user', 500);
        }
    }
}
