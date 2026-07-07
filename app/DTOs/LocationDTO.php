<?php

namespace App\DTOs;

class LocationDTO
{
    public function __construct(
        public readonly string $location,
        public readonly int $city_id,
        public readonly int $status = 1,

    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            location: $data['location'],
            city_id: $data['city_id'],
            status: $data['status'] ?? 1,
        );
    }

    public function toArray(): array
    {
        return [
            'location'  => $this->location,
            'city_id'  => $this->city_id,
            'status' => $this->status,
        ];
    }
}
