<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Event;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 4);
        $pricePerTicket = fake()->randomElement([29.99, 49.99, 79.99, 99.99, 149.99]);

        return [
            'reservation_id' => Reservation::factory(),
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'quantity' => $quantity,
            'total_amount' => $pricePerTicket * $quantity,
            'order_number' => $this->generateOrderNumber(),
            'status' => OrderStatus::COMPLETED,
        ];
    }

    public function forReservation(Reservation $reservation): static
    {
        return $this->state(fn (array $attributes): array => [
            'reservation_id' => $reservation->id,
            'user_id' => $reservation->user_id,
            'event_id' => $reservation->event_id,
            'quantity' => $reservation->quantity,
            'total_amount' => $reservation->total_amount,
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => $user->id,
        ]);
    }

    public function forEvent(Event $event): static
    {
        return $this->state(fn (array $attributes): array => [
            'event_id' => $event->id,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => OrderStatus::COMPLETED,
        ]);
    }

    public function refunded(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => OrderStatus::REFUNDED,
        ]);
    }

    private function generateOrderNumber(): string
    {
        return sprintf(
            'ORD-%s-%s',
            now()->format('Ymd'),
            strtoupper(fake()->unique()->bothify('??####'))
        );
    }
}
