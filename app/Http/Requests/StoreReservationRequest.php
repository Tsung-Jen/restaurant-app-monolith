<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow public access for customer reservations
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'surname' => 'required|string|min:2|max:100',
            'phone_number' => 'required|string|min:10|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'email' => 'nullable|email|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'session' => 'required|in:lunch,dinner',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1|max:55',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'surname.required' => 'Please enter your surname',
            'surname.min' => 'Surname must be at least 2 characters',
            'phone_number.required' => 'Please enter your phone number',
            'phone_number.regex' => 'Please enter a valid phone number',
            'reservation_date.required' => 'Please select a reservation date',
            'reservation_date.after_or_equal' => 'Reservation date must be today or later',
            'session.required' => 'Please select a session (lunch or dinner)',
            'session.in' => 'Please select a valid session',
            'reservation_time.required' => 'Please select a reservation time',
            'number_of_guests.required' => 'Please enter the number of guests',
            'number_of_guests.min' => 'Number of guests must be at least 1',
            'number_of_guests.max' => 'Maximum 55 guests per reservation',
            'email.email' => 'Please enter a valid email address',
        ];
    }
}
