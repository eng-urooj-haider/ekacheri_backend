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
        public readonly ?string $status,
        public readonly array $attendeeIds,
        public readonly array $dfp_ids,
        public readonly ?string $complaint_received = null, // FIX: restored, edit-only
        public readonly ?string $session_convened = null,   // FIX: restored, edit-only
        public readonly ?string $session_not_conv_reason = null, // FIX: restored, edit-only
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
            complaint_received: $data['complaint_received'] ?? null,
            session_convened: $data['session_convened'] ?? null,
            session_not_conv_reason: $data['session_not_conv_reason'] ?? null,

        );
    }

    /**
     * Convert to the snake_case shape the Ekachehri model / DB expects.
     * Excludes attendeeIds/dfpIds since those are synced separately (pivot tables).
     */
    public function toModelArray(): array
    {
        return array_filter([
            'kachehri_number' => $this->kachehriNumber,
            'venue' => $this->venue,
            'session' => $this->session,
            'kachehri_date' => $this->kachehriDate,
            'kachehri_time' => $this->kachehriTime,
            'location' => $this->location,
            'status' => $this->status,
            'dfp_ids' => implode(',', $this->dfp_ids),
            'complaint_received' => $this->complaint_received,
            'session_convened' => $this->session_convened,
            'session_not_conv_reason' => $this->session_not_conv_reason,
        ], fn($value) => $value !== null && $value !== '');
    }
}
