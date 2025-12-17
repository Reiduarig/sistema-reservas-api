<?php

namespace App\Repositories\Eloquent;
use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
   public function findById(int $id): ?Cart
    {
        return Cart::with('items.event')->find($id);
    }

    public function findByUserId(int $userId): ?Cart
    {
        return Cart::with('items.event')->where('user_id', $userId)->first();
    }

    public function findOrCreateByUserId(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function deleteAllItems(Cart $cart): bool
    {
        return $cart->items()->delete() !== false;
    }

    public function findItemByCartAndEvent(int $cartId, int $eventId): ?CartItem
    {
        return CartItem::where('cart_id', $cartId)
            ->where('event_id', $eventId)
            ->first();
    }

    public function saveItem(CartItem $cartItem): bool
    {
        return $cartItem->save();
    }

    public function deleteItem(CartItem $cartItem): bool
    {
        return $cartItem->delete();
    }
}
