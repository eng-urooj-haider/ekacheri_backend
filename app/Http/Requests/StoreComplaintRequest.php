<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    public function rules(): array
    {
        return [
            'customer_number' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:255'],
            'telco' => ['required', 'in:Mobilink,Telenor,Ufone,Warid,Zong'],
            'complaint_category' => ['required', 'in:New Customer,Repeat Customer'],
            'complaint_type' => ['required', 'in:Complaint,Grievance,Suggestion,Information Seeking'],
            'complaint_details' => ['required', 'string'],
            'priority' => ['required', 'in:Normal,Urgent,Immediate,Cancelled'],
            'status' => ['required', 'in:Open,Close'],
            'departmentIds' => ['required', 'array', 'min:1'],
            'departmentIds.*' => ['integer', 'exists:departments,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_number.required' => 'Customer number is required.',
            'contact_number.required' => 'Contact number is required.',
            'telco.required' => 'Please select a network.',
            'complaint_category.required' => 'Please select a complaint category.',
            'complaint_type.required' => 'Please select a complaint type.',
            'complaint_details.required' => 'Complaint details are required.',
            'priority.required' => 'Please select a priority.',
            'status.required' => 'Please select a status.',
            'departmentIds.required' => 'Select at least one department.',
            'departmentIds.min' => 'Select at least one department.',
        ];
    }
}
