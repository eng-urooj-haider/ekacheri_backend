<?php

namespace App\Services;

// use App\Http\Requests\StoreUserRequest;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    // public function __construct(private UserService $userService) {}

    // public function index()
    // {
    //     return response()->json($this->userService->getAll());
    // }
    public function getAll(): Collection
    {
        return User::all();
    }
    public function save(UserDTO $dto): User
    {
        $data = $dto->toArray();
        $data['roleId'] = 4;
        $data['createdBy'] = 1;
        $data['status'] = 'Active';
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Password is optional on create in your form — don't store an empty string
            unset($data['password']);
        }

        return User::create($data);
    }
     public function getDfp(int $id):User
    {
        return User::findOrFail($id);
    }
}
