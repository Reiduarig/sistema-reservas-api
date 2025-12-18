<?php

namespace App\Actions\Cart;

use App\DataTransferObjects\AddToCartData;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Event;

class AddItemToCartPassable
{
    public ?Event $event = null;
    public ?Cart $cart = null;
    public ?CartItem $cartItem = null;
    public ?CartItem $existingItem = null;

    public function __construct(
        public AddToCartData $data,

    ) {}
}
