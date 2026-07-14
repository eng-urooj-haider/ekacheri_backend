<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KacheriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kachehriNumber' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('kacheris', 'kachehriNumber')->ignore($this->route('kacheri')),
            ],
            'venue' => ['required', 'string', 'max:255'],
            'liveSession' => ['nullable', Rule::in(['Yes', 'No'])],
            'kachehriDate' => ['required', 'date'],
            'kachehriTime' => ['required', 'date_format:H:i'],
            'location' => ['required', 'exists:locations,location'],
            'status' => ['required', Rule::in(['Pending', 'Scheduled', 'Completed', 'Cancelled'])],
            'attendeeIds' => ['nullable', 'array'],
            'attendeeIds.*' => ['integer', 'exists:dfps,id'],
            'dfpIds' => ['nullable', 'array'],
            'dfpIds.*' => ['integer', 'exists:dfps,id'],
        ];
    }
}
