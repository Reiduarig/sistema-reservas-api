<?php

namespace App\Actions\Cart\AddItemToCart;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Actions\Cart\AddItemToCartPassable;
use App\Models\CartItem;
use Closure;
use Illuminate\Validation\ValidationException;

class CheckExistingCartItemPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {}

    public function handle(AddItemToCartPassable $passable, Closure $next): mixed
    {
        $passable->existingItem = $this->cartRepository->findItemByCartAndEvent(
            $passable->cart->id,
            $passable->data->eventId,
        );

        if ($passable->existingItem instanceof CartItem) {
            
            $newQuantity = $passable->existingItem->quantity + $passable->data->quantity;

            if($passable->event->available_tickets < $newQuantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough tickets available for the requested quantity.',
                ]);
            }

        }

        return $next($passable);
    }
}
