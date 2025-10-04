<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'checkin_at' => ['nullable', 'date', 'before_or_equal:now'],
            'checkout_at' => ['nullable', 'date', 'after:checkin_at'],
            'status' => ['required', 'in:present,absent'],
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
            'appointment_id.exists' => 'Selected appointment does not exist.',
            'checkin_at.date' => 'Please enter a valid check-in date.',
            'checkin_at.before_or_equal' => 'Check-in time cannot be in the future.',
            'checkout_at.date' => 'Please enter a valid check-out date.',
            'checkout_at.after' => 'Check-out time must be after check-in time.',
            'status.required' => 'Please select attendance status.',
            'status.in' => 'Status must be either present or absent.',
        ];
    }
}
