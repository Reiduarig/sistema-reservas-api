<?php

namespace App\Repositories\Eloquent;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Str;

class OrderRepository implements OrderRepositoryInterface
{
    public function findByIdForUser(int $id, int $userId): ?Order
    {
        return Order::with(['event','reservation'])
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function findByUser(int $userId): Collection
    {
        return Order::with(['event','reservation'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function save(Order $order): bool
    {
        return $order->save();
    }

    public function generateOrderNumber(): string
    {
        return Str::upper(Str::random(8));
    }

}
