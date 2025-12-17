<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function findByIdForUser(int $id, int $userId): ?Order;

    public function findByUser(int $userId): Collection;

    public function save(Order $order): bool;

    public function generateOrderNumber(): string;
}
