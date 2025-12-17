<?php

namespace App\DataTransferObjects;

readonly class CreateReservationData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $userId,
        public int $cartId,
    ) {}
}
