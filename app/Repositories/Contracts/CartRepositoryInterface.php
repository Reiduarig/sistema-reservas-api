<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;
use App\Models\CartItem;

interface CartRepositoryInterface
{
    public function findById(int $id): ?Cart;

    public function findByUserId(int $userId): ?Cart;

    public function findOrCreateByUserId(int $userId): Cart;

    public function deleteAllItems(Cart $cart): bool;

    public function findItemByCartAndEvent(int $cartId, int $eventId): ?CartItem;

    public function saveItem(CartItem $cartItem): bool;

    public function deleteItem(CartItem $cartItem): bool;
}
