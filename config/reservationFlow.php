<?php 

return [

    /*
    |--------------------------------------------------------------------------
    | Reservation Flow Configuration
    |--------------------------------------------------------------------------
    | Here you may configure the settings for the reservation flow in your application.
    | This includes the time-to-live (TTL) for reservations.
    |--------------------------------------------------------------------------
    */

    'reservation_ttl_minutes' => (int) env('RESERVATION_DEFAULT_TTL', 2),
];