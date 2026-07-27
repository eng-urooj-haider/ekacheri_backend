<?php

namespace App\Services;

use App\DTOs\DepartmentDTO;
use App\Models\Department;

class DepartmentService
{
    public function getAll($perPage = 10, $page = 1, $search = null)
    {
        $query =  Department::orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhere('email_addresses', 'like', "%{$search}%");
            });
        }
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    public function saveDepartment(DepartmentDTO $dto): Department
    {
        $data = $dto->toArray();
        $data['status'] = 1;
        return Department::create($data);
    }

    public function getDepartment(int $id): Department
    {
        return Department::findOrFail($id);
    }

    public function updateDepartment(int $id, DepartmentDTO $dto): Department
    {
        $department = Department::findOrFail($id);
        $department->update($dto->toArray());

        return $department->fresh();
    }
    public function deleteDepartment(Department $Department): void
    {
        $Department->delete();
    }
}
