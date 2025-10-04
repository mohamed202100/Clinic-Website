<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsultationRequest extends FormRequest
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
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'attendance_id' => [
                'nullable', 
                'exists:attendances,id',
                Rule::exists('attendances', 'id')->where(function ($query) {
                    return $query->where('patient_id', $this->input('patient_id'));
                })
            ],
            'doctor_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'doctor');
                }),
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'treatment' => ['nullable', 'string', 'max:1000'],
            'next_visit' => ['nullable', 'date', 'after:today'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'Selected patient does not exist.',
            'attendance_id.exists' => 'Selected attendance does not exist or does not belong to this patient.',
            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'Selected doctor does not exist.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
            'diagnosis.max' => 'Diagnosis cannot exceed 1000 characters.',
            'treatment.max' => 'Treatment cannot exceed 1000 characters.',
            'next_visit.date' => 'Please enter a valid date for next visit.',
            'next_visit.after' => 'Next visit must be in the future.',
        ];
    }
}
