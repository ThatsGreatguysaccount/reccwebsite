<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function index(): JsonResponse
    {
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
        ];

        return $this->success($users, 'Users retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // In a real app, you would create the user here
        $user = [
            'id' => 3,
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        return $this->success($user, 'User created successfully', 201);
    }
}

