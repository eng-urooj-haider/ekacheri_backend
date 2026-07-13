<?php

namespace App\DTOs;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $email_addresses,
    ) {}

    /**
     * Create a DTO instance from a validated FormRequest.
     */
    public static function fromRequest(DepartmentRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            title: $validated['title'],
            email_addresses: $validated['email_addresses'],
        );
    }
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'email_addresses' => $this->email_addresses,
        ];
    }
}
