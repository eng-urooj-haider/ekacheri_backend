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
            'name' => ['required', 'string', 'max:255'],
            'telco' => ['required', 'in:Mobilink,Telenor,Ufone,Warid,Zong'],
            'complaint_category' => ['required', 'in:New Customer,Repeat Customer'],
            'complaint_type' => ['required', 'in:Complaint,Grievance,Suggestion,Information Seeking'],
            'complaint_details' => ['required', 'string'],
            'priority' => ['required', 'in:Normal,Urgent,Immediate,Cancelled'],
            'status' => ['required', 'in:Open,Close'],
            'disposal_status'=>['nullable' , 'string'],
            'closure_date'=>['nullable' , 'string'],
            'closure_time'=>['nullable' , 'string'],
            'department_status'=>['nullable' , 'string'],
            'customer_feedback'=>['nullable' , 'string'],
            'departmentIds'=>["nullable",'array']
        ];
    }
    public function messages(): array
    {
        return [
            'customer_number.required' => 'Customer number is required.',
            'contact_number.required' => 'Contact number is required.',
            'name.required' => 'Name is required.',
            'telco.required' => 'Please select a network.',
            'complaint_category.required' => 'Please select a complaint category.',
            'complaint_type.required' => 'Please select a complaint type.',
            'complaint_details.required' => 'Complaint details are required.',
            'priority.required' => 'Please select a priority.',
            'status.required' => 'Please select a status.'
        ];
    }
}
