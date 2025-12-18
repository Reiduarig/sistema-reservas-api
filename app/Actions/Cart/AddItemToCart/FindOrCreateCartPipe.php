<?php

namespace App\Actions\Cart\AddItemToCart;

use App\Repositories\Contracts\CartRepositoryInterface;
use App\Actions\Cart\AddItemToCartPassable;
use Closure;

class FindOrCreateCartPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {}

    public function handle(AddItemToCartPassable $passable, Closure $next): mixed
    {
        $passable->cart = $this->cartRepository->findOrCreateByUserId($passable->data->userId);

        return $next($passable);
    }
}
