<?php

namespace App\Actions\Cart;

use App\Actions\Cart\AddItemToCart\ValidateEventAvailabilityPipe;
use App\Actions\Cart\AddItemToCart\FindOrCreateCartPipe;
use App\Actions\Cart\AddItemToCart\CheckExistingCartItemPipe;
use App\Actions\Cart\AddItemToCart\SaveCartItemPipe;
use App\DataTransferObjects\AddToCartData;
use App\Models\CartItem;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class AddItemToCartAction
{
    public function execute(AddToCartData $data): CartItem
    {
       return DB::transaction(function () use ($data): ?CartItem {
            $passable = new AddItemToCartPassable($data);

            app(Pipeline::class)
                ->send($passable)
                ->through([
                    ValidateEventAvailabilityPipe::class,
                    FindOrCreateCartPipe::class,
                    CheckExistingCartItemPipe::class,
                    SaveCartItemPipe::class,
                ])
                ->thenReturn();

            return $passable->cartItem;
           
        });
    }
}
