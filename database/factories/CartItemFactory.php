<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Event;
use App\Models\CartItem;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'event_id' => Event::factory(),
            'quantity' => fake()->numberBetween(1, 4),
            'price_snapshot' => fake()->randomElement([29.99, 49.99, 79.99, 99.99, 149.99]),
        ];
    }

    public function forCart(Cart $cart): static
    {
        return $this->state(fn (array $attributes): array => [
            'cart_id' => $cart->id,
        ]);
    }

    public function forEvent(Event $event): static
    {
        return $this->state(fn (array $attributes): array => [
            'event_id' => $event->id,
            'price_snapshot' => $event->price_per_ticket,
        ]);
    }

    public function withQuantity(int $quantity): static
    {
        return $this->state(fn (array $attributes): array => [
            'quantity' => $quantity,
        ]);
    }
}
