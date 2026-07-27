<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserService
{
      public function getAll($perPage = 10, $page = 1, $search = null)
    {
        $query =  User::orderBy('created_at','desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('executive_number', 'like', "%{$search}%")->orWhere('mobile', 'like', "%{$search}%");
            });
        }
        return $query->paginate($perPage, ['*'], 'page', $page);

    }
    public function getById(int $id): User
    {
        return User::with('dept')->where('id',$id)->first();
    }

    public function save(UserDTO $dto): User
    {
        $data = $dto->toArray();
        $data['createdBy'] = 1;
        $data['status'] = 'Active';

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return User::create($data);
    }

    public function update(int $id, UserDTO $dto): User
    {
        $user = User::findOrFail($id);
        $data = $dto->toArray();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }

    public function delete(int $id): bool
    {
        $user = User::findOrFail($id);

        return (bool) $user->delete();
    }

    public function toggleStatus(int $id): User
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
