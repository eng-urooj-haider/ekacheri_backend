<?php

namespace App\Services;

use App\DTOs\ComplaintDTO;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class ComplaintService
{
    public function getAll()
    {
        return Complaint::all();
    }

    public function create(ComplaintDTO $dto): Complaint
    {
        return DB::transaction(function () use ($dto) {
            $complaint = Complaint::create($dto->toModelArray());
            return $complaint;
        });
    }
}
