<?php

namespace App\Http\Controllers\Api;

use App\Actions\Cart\AddItemToCartAction;
use App\DataTransferObjects\AddToCartData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddItemToCartRequest;
use App\Http\Resources\CartItemResource;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {}

    public function addItem(
        AddItemToCartRequest $request,
        AddItemToCartAction $action
    ): CartItemResource {
       
        $data = new AddToCartData(
            userId: $request->user()->id,
            eventId: $request->integer('event_id'),
            quantity: $request->integer('quantity')
        );

        $cartItem = $action->execute($data);

        return new CartItemResource($cartItem);
    }
}
