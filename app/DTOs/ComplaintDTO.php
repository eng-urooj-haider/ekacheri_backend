<?php

namespace App\DTOs;

class ComplaintDTO
{
    public function __construct(
        public readonly string $customer_number,
        public readonly string $contact_number,
        public readonly string $name,
        public readonly string $telco,
        public readonly string $complaint_category,
        public readonly string $complaint_type,
        public readonly string $complaint_details,
        public readonly string $priority,
        public readonly string $status,
        public readonly array $department,
        public readonly ?string $disposal_status = null,
        public readonly ?string $closure_date = null,
        public readonly ?string $closure_time = null,
        public readonly ?string $department_status = null,
        public readonly ?string $customer_feedback = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            customer_number: $data['customer_number'],
            contact_number: $data['contact_number'],
            name: $data['name'],
            telco: $data['telco'],
            complaint_category: $data['complaint_category'],
            complaint_type: $data['complaint_type'],
            complaint_details: $data['complaint_details'],
            priority: $data['priority'],
            status: $data['status'],
            department: $data['departmentIds'],
            disposal_status: $data['disposal_status'] ?? null,
            closure_date: $data['closure_date'] ?? null,
            closure_time: $data['closure_time'] ?? null,
            department_status: $data['department_status'] ?? null,
            customer_feedback: $data['customer_feedback'] ?? null,
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
            'name' => $this->name,
            'telco' => $this->telco,
            'complaint_category' => $this->complaint_category,
            'complaint_type' => $this->complaint_type,
            'complaint_details' => $this->complaint_details,
            'priority' => $this->priority,
            'status' => $this->status,
            'disposal_status' => $this->disposal_status,
            'closure_date' => $this->closure_date,
            'closure_time' => $this->closure_time,
            'department_status' => $this->department_status,
            'customer_feedback' => $this->customer_feedback,
            'department' => implode(',', $this->department),

        ];
    }
}