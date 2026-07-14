<?php

namespace App\Services;

use App\DTOs\KacheriDTO;
use App\Models\Kacheri;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class KacheriService
{
    public function getAll(): Collection
    {
        return Kacheri::with(['attendees', 'dfps'])->latest('kachehriDate')->get();
    }

    public function getById(int $id): Kacheri
    {
        return Kacheri::with(['attendees', 'dfps'])->findOrFail($id);
    }

    public function getLatestId(): ?int
    {
        return Kacheri::latest('id')->value('id');
    }

    public function save(KacheriDTO $dto): Kacheri
    {
        return DB::transaction(function () use ($dto) {
            $kacheri = Kacheri::create($dto->toArray());

            $kacheri->attendees()->sync($dto->attendeeIds);
            $kacheri->dfps()->sync($dto->dfpIds);

            return $kacheri->load(['attendees', 'dfps']);
        });
    }

    public function update(int $id, KacheriDTO $dto): Kacheri
    {
        return DB::transaction(function () use ($id, $dto) {
            $kacheri = Kacheri::findOrFail($id);
            $kacheri->update($dto->toArray());

            $kacheri->attendees()->sync($dto->attendeeIds);
            $kacheri->dfps()->sync($dto->dfpIds);

            return $kacheri->fresh(['attendees', 'dfps']);
        });
    }

    public function delete(int $id): bool
    {
        $kacheri = Kacheri::findOrFail($id);

        return (bool) $kacheri->delete();
    }

    public function getByStatus(string $status): Collection
    {
        return Kacheri::with(['attendees', 'dfps'])
            ->where('status', $status)
            ->latest('kachehriDate')
            ->get();
    }
}
