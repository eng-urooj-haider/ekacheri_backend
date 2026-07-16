<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEkachehriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust to your auth/policy logic
    }

    public function rules(): array
    {
        // FIX: route parameter is named "id", not "ekachehri" — check your
        // route file (Route::put('/{id}', ...)) if this ever changes
        $ekachehriId = $this->route('kachehry');

        return [
            'kachehriNumber' => [
                'required',
                'integer',
                Rule::unique('ekachehris', 'kachehri_number')->ignore($ekachehriId),
            ],
            'venue' => ['required', 'string', 'max:255'],
            'session' => ['required'],
            'kachehriDate' => ['required', 'date'],
            // FIX: accept both "H:i" and "H:i:s" so legacy data with seconds doesn't fail
            'kachehriTime' => ['required', 'date_format:H:i,H:i:s'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Active,Inactive'],
            'attendeeIds' => ['required', 'array', 'min:1'],
            'attendeeIds.*' => ['integer', 'exists:users,id'],
            'dfpIds' => ['required', 'array', 'min:1'],
            'complaint_received' => ['nullable'],
            'session_convened' => ['nullable'],
            'session_not_conv_reason' => ['nullable'],

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
            'kachehriTime.date_format' => 'Kachehri time must be a valid time (e.g. 11:00).',
            'location.required' => 'Please select a location.',
            'status.required' => 'Please select a status.',
            'attendeeIds.required' => 'Select at least one attendee.',
            'attendeeIds.min' => 'Select at least one attendee.',
            'dfpIds.required' => 'Select at least one DFP.',
            'dfpIds.min' => 'Select at least one DFP.',
        ];
    }
}
