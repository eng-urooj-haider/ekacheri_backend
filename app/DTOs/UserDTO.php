<?php

namespace App\DTOs;

use App\Http\Requests\UserRequest;

class UserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $gender,
        public readonly ?string $password,
        public readonly string $telco,
        public readonly string $mobile,
        public readonly string $executive_number,
        public readonly string $designation,
        public readonly string $department,
    ) {}

    /**
     * Build a UserDTO from a validated Form Request.
     */
    public static function fromRequest(UserRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            name: $validated['name'],
            email: $validated['email'],
            gender: $validated['gender'],
            password: $validated['password'] ?? null,
            telco: $validated['telco'],
            mobile: $validated['mobile'],
            executive_number: $validated['executive_number'],
            designation: $validated['designation'],
            department: (int) $validated['department'],
        );
    }

    /**
     * Convert the DTO back into a plain array, ready for Model::create()/update().
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'password' => $this->password,
            'telco' => $this->telco,
            'mobile' => $this->mobile,
            'executive_number' => $this->executive_number,
            'designation' => $this->designation,
            'department' => $this->department,
        ];
    }
}
