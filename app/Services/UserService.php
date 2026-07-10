<?php

namespace App\Services;

// use App\Http\Requests\StoreUserRequest;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    // public function __construct(private UserService $userService) {}

    // public function index()
    // {
    //     return response()->json($this->userService->getAll());
    // }

    public function save(UserDTO $dto): User
    {
        $data = $dto->toArray();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Password is optional on create in your form — don't store an empty string
            unset($data['password']);
        }

        return User::create($data);
    }
}
