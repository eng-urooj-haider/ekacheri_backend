<?php

namespace App\DTOs;

class EkachehriDTO
{
    public function __construct(
        public readonly int $kachehriNumber,
        public readonly string $venue,
        public readonly string $session,
        public readonly string $kachehriDate,
        public readonly string $kachehriTime,
        public readonly string $location,
        public readonly string $status,
        public readonly array $attendeeIds,
        public readonly array $dfp_ids,
    ) {}

    /**
     * Build the DTO from a validated request array
     * (works with both StoreEkachehriRequest and UpdateEkachehriRequest).
     */
    public static function fromArray(array $data): self
    {
        return new self(
            kachehriNumber: (int) $data['kachehriNumber'],
            venue: $data['venue'],
            session: $data['session'],
            kachehriDate: $data['kachehriDate'],
            kachehriTime: $data['kachehriTime'],
            location: $data['location'],
            status: $data['status'],
            attendeeIds: $data['attendeeIds'],
            dfp_ids: $data['dfpIds'],
        );
    }

    /**
     * Convert to the snake_case shape the Ekachehri model / DB expects.
     * Excludes attendeeIds/dfpIds since those are synced separately (pivot tables).
     */
    public function toModelArray(): array
    {
        return [
            'kachehri_number' => $this->kachehriNumber,
            'venue' => $this->venue,
            'session' => $this->session,
            'kachehri_date' => $this->kachehriDate,
            'kachehri_time' => $this->kachehriTime,
            'location' => $this->location,
            'status' => $this->status,
            'dfp_ids' => implode(',', $this->dfp_ids)
        ];
    }
}
