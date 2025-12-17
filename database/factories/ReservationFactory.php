<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Event;
use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 4);
        $pricePerTicket = fake()->randomElement([29.99, 49.99, 79.99, 99.99, 149.99]);

        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'quantity' => $quantity,
            'total_amount' => $pricePerTicket * $quantity,
            'status' => ReservationStatus::PENDING,
            'expires_at' => now()->addMinutes(15),
            'confirmed_at' => null,
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes): array => [
            'user_id' => $user->id,
        ]);
    }

    public function forEvent(Event $event): static
    {
        return $this->state(function (array $attributes) use ($event): array {
            $quantity = $attributes['quantity'] ?? fake()->numberBetween(1, 4);

            return [
                'event_id' => $event->id,
                'total_amount' => $event->price_per_ticket * $quantity,
                'expires_at' => now()->addMinutes($event->reservation_ttl_minutes),
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ReservationStatus::PENDING,
            'expires_at' => now()->addMinutes(15),
            'confirmed_at' => null,
        ]);
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ReservationStatus::CONFIRMED,
            'confirmed_at' => now(),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ReservationStatus::EXPIRED,
            'expires_at' => now()->subMinutes(fake()->numberBetween(1, 60)),
            'confirmed_at' => null,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ReservationStatus::CANCELLED,
            'confirmed_at' => null,
        ]);
    }

    public function expiringIn(int $minutes): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ReservationStatus::PENDING,
            'expires_at' => now()->addMinutes($minutes),
        ]);
    }

    public function withQuantity(int $quantity): static
    {
        return $this->state(fn (array $attributes): array => [
            'quantity' => $quantity,
        ]);
    }
}
