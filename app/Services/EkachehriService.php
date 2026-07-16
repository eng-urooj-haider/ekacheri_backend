<?php

namespace App\Services;

use App\DTOs\EkachehriDTO;
use App\Models\Ekachehri;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EkachehriService
{
    public function getAll(): Collection
    {
        return Ekachehri::all();
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
            $ekachehri = Ekachehri::create($dto->toModelArray());

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
