<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location' => [
                'required',
                'string',
                'max:255',
                Rule::unique('locations', 'location')
                    ->where(fn($query) => $query->where('city_id', $this->city_id))->ignore($this->route('location')),
            ],
            'city_id'  => ['required', 'integer', Rule::exists('cities', 'id')],
            'status'   => ['nullable', 'boolean'],
        ];
    }
}
