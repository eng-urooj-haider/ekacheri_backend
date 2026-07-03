<?php

namespace App\DTOs;

class CityDTO
{
    public function __construct(
        public readonly string $title,
        public readonly int $status = 1,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'],
            status: $data['status'] ?? 1,
        );
    }

    public function toArray(): array
    {
        return [
            'title'  => $this->title,
            'status' => $this->status,
        ];
    }
}
