<?php

namespace App\DataTransferObjects;

readonly class AddToCartData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $userId,
        public int $eventId,
        public int $quantity
    ) {}
        
}
