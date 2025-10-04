<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Clinic Working Hours Configuration
    |--------------------------------------------------------------------------
    |
    | Define the clinic's working hours and appointment slot duration.
    |
    */
    
    'working_hours' => [
        'start_time' => '08:00',    // Clinic opens at 8:00 AM
        'end_time' => '17:00',      // Clinic closes at 5:00 PM
        'break_start' => '12:00',   // Lunch break starts at 12:00 PM
        'break_end' => '13:00',     // Lunch break ends at 1:00 PM
        'working_days' => [1, 2, 3, 4, 5, 6], // Monday to Saturday (1=Monday, 7=Sunday)
    ],
    
    'appointment_duration' => 30, // Appointment slots in minutes  
    'slot_duration' => 30,        // Time slot duration in minutes
    'buffer_time' => 0,           // Buffer time between appointments in minutes
    
    'max_advance_booking' => 30,   // Maximum days in advance for booking
    'min_advance_booking' => 1,    // Minimum hours in advance for booking
];
