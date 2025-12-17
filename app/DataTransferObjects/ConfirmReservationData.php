<?php

namespace App\DataTransferObjects;

readonly class ConfirmReservationData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $userId,
        public int $reservationId,
    ) {}
    
}
