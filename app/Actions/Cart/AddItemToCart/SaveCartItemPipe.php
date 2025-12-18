<?php

namespace App\Actions\Cart\AddItemToCart;

use App\Repositories\Contracts\CartRepositoryInterface;
use App\Actions\Cart\AddItemToCartPassable;
use App\Models\CartItem;
use Closure;

class SaveCartItemPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {}

    public function handle(AddItemToCartPassable $passable, Closure $next): mixed
    {
        if($passable->existingItem instanceof \App\Models\CartItem) {
            $passable->existingItem->quantity += $passable->data->quantity;
            $this->cartRepository->saveItem($passable->existingItem);
            $passable->cartItem = $passable->existingItem->fresh();
            
            return $next($passable);
        } 

        $newItem = new CartItem([
            'cart_id' => $passable->cart->id,
            'event_id' => $passable->data->eventId,
            'quantity' => $passable->data->quantity,
            'price_snapshot' => $passable->event->price_per_ticket,
        ]);

        $this->cartRepository->saveItem($newItem);
        $passable->cartItem = $newItem->fresh();

        return $next($passable);
    }
}
