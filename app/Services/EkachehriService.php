<?php

namespace App\Services;

use App\DTOs\EkachehriDTO;
use App\Models\Ekachehri;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EkachehriService
{
    public function getAll($perPage = 10, $page = 1, $search = null)
    {
        if ($user && $user->role_id == 2) {
            $query = Ekachehri::whereRaw("FIND_IN_SET(?, dfp_ids)", [$user->id])
                ->orderBy('created_at', 'desc');
        } else {
            $query = Ekachehri::orderBy('created_at', 'desc');
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kachehri_number', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getById(int $id): Ekachehri
    {
        return Ekachehri::with('attendees')->findOrFail($id);
    }

    /**
     * Next available Kachehri number — powers the frontend's
     * getLatestId() call used to prefill the "Kachehri Number" field.
     */
    public function getLatestId(): int
    {
        return (int) (Ekachehri::max('id') ?? 0);
    }

    public function create(EkachehriDTO $dto): Ekachehri
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toModelArray();
            $data['createdby'] = auth()->id();
            $data['uuid'] = Str::uuid();
            $ekachehri = Ekachehri::create($data);

            $ekachehri->attendees()->sync($dto->attendeeIds);
            // $ekachehri->dfps()->sync($dto->dfpIds);

            return $ekachehri->load(['attendees']);
        });
    }

    public function update(int $id, EkachehriDTO $dto): Ekachehri
    {
        return DB::transaction(function () use ($id, $dto) {
            $ekachehri = Ekachehri::findOrFail($id);

            $ekachehri->update($dto->toModelArray());

            $ekachehri->attendees()->sync($dto->attendeeIds);

            return $ekachehri->load(['attendees']);
        });
    }

    public function delete(int $id): void
    {
        $ekachehri = Ekachehri::findOrFail($id);
        $ekachehri->delete(); // pivot rows cascade via FK constraints in the migration
    }
}
