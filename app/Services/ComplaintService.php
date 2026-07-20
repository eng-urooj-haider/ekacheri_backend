<?php

namespace App\Services;

use App\DTOs\ComplaintDTO;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class ComplaintService
{
    public function getAll()
    {
        return Complaint::with('user')->get();
    }

    public function create(ComplaintDTO $dto): Complaint
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toModelArray();
            $data['createdby'] = auth()->id();
            $complaint = Complaint::create($data);
            return $complaint;
        });
    }
    public function getComplaint(int $id): Complaint
    {
        return Complaint::findOrFail($id);
    }
    public function update(int $id, ComplaintDTO $dto): Complaint
    {
        return DB::transaction(function () use ($id, $dto) {
            $complaint = Complaint::findOrFail($id);

            $complaint->update($dto->toModelArray());

            return $complaint;
        });
    }
}
