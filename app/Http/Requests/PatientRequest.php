<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $patientId = $this->route('patient') ? $this->route('patient')->id : null;

        return [
            'medical_record' => [
                'required',
                'string',
                Rule::unique('patients', 'medical_record')->ignore($patientId)
            ],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s\(\)]+$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'medical_record.required' => 'Medical record number is required.',
            'medical_record.unique' => 'This medical record number already exists.',
            'name.required' => 'Patient name is required.',
            'name.max' => 'Patient name cannot exceed 255 characters.',
            'phone.regex' => 'Please enter a valid phone number.',
            'email.email' => 'Please enter a valid email address.',
            'dob.date' => 'Please enter a valid date.',
            'dob.before' => 'Date of birth must be in the past.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ];
    }
}
