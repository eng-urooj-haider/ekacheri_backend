<?php

namespace App\DTOs;

class ComplaintDTO
{
    public function __construct(
        public readonly string $customer_number,
        public readonly string $contact_number,
        public readonly string $telco,
        public readonly string $complaint_category,
        public readonly string $complaint_type,
        public readonly string $complaint_details,
        public readonly string $priority,
        public readonly string $status,
        public readonly array $departmentIds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            customer_number: $data['customer_number'],
            contact_number: $data['contact_number'],
            telco: $data['telco'],
            complaint_category: $data['complaint_category'],
            complaint_type: $data['complaint_type'],
            complaint_details: $data['complaint_details'],
            priority: $data['priority'],
            status: $data['status'],
            departmentIds: $data['departmentIds'],
        );
    }

    /**
     * Convert to the shape the Complaint model / DB expects.
     * Excludes departmentIds since that's synced separately via a pivot table.
     */
    public function toModelArray(): array
    {
        return [
            'customer_number' => $this->customer_number,
            'contact_number' => $this->contact_number,
            'telco' => $this->telco,
            'complaint_category' => $this->complaint_category,
            'complaint_type' => $this->complaint_type,
            'complaint_details' => $this->complaint_details,
            'priority' => $this->priority,
            'status' => $this->status,
        ];
    }
}
