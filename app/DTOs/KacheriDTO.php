<?php

namespace App\DTOs;

use App\Http\Requests\KacheriRequest;

class KacheriDTO
{
    public function __construct(
        public readonly ?string $kachehriNumber,
        public readonly string $venue,
        public readonly ?string $liveSession,
        public readonly string $kachehriDate,
        public readonly string $kachehriTime,
        public readonly string $location,
        public readonly string $status,
        public readonly array $attendeeIds = [],
        public readonly array $dfpIds = [],
    ) {}

    public static function fromRequest(KacheriRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            kachehriNumber: $validated['kachehriNumber'] ?? null,
            venue: $validated['venue'],
            liveSession: $validated['liveSession'] ?? null,
            kachehriDate: $validated['kachehriDate'],
            kachehriTime: $validated['kachehriTime'],
            location: $validated['location'],
            status: $validated['status'],
            attendeeIds: $validated['attendeeIds'] ?? [],
            dfpIds: $validated['dfpIds'] ?? [],
        );
    }

    /**
     * Fields that map directly onto the kacheris table.
     * attendeeIds / dfpIds are handled separately via pivot tables,
     * so they're excluded here.
     */
    public function toArray(): array
    {
        return [
            'kachehriNumber' => $this->kachehriNumber,
            'venue' => $this->venue,
            'liveSession' => $this->liveSession,
            'kachehriDate' => $this->kachehriDate,
            'kachehriTime' => $this->kachehriTime,
            'location' => $this->location,
            'status' => $this->status,
        ];
    }
}
