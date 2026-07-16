<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkachehriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    public function rules(): array
    {
        return [
            'kachehriNumber' => ['required', 'integer', 'unique:ekachehris,kachehri_number'],
            'venue' => ['required', 'string', 'max:255'],
            'session' => ['required'],
            'kachehriDate' => ['required', 'date'],
            'kachehriTime' => ['required'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Active,Inactive'],
            'attendeeIds' => ['required', 'array', 'min:1'],
            'attendeeIds.*' => ['integer', 'exists:users,id'],
            'dfpIds' => ['required', 'array', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'kachehriNumber.required' => 'Kachehri number is required.',
            'kachehriNumber.unique' => 'This Kachehri number is already in use.',
            'venue.required' => 'Venue is required.',
            'session.required' => 'Please select session.',
            'kachehriDate.required' => 'Kachehri date is required.',
            'kachehriTime.required' => 'Kachehri time is required.',
            'location.required' => 'Please select a location.',
            'status.required' => 'Please select a status.',
            'attendeeIds.required' => 'Select at least one attendee.',
            'attendeeIds.min' => 'Select at least one attendee.',
            'dfpIds.required' => 'Select at least one DFP.',
            'dfpIds.min' => 'Select at least one DFP.',
        ];
    }
}
