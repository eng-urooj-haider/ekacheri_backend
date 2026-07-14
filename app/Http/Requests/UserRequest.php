<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('dfp'))],
            'gender' => ['required'],
            'password' => ['nullable', 'string', 'min:8'],
            'telco' => ['required'],
            'mobile' => ['required', 'string', 'regex:/^03\d{9}$/'],
            'executive_number' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            // 'department' => ['required', 'exists:departments,id'],
            'department' => ['required'],

        ];
    }
}
