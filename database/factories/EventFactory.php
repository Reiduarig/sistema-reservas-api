<?php

namespace Database\Factories;

use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    private array $eventTypes = [
        'Concierto de %s',
        'Festival %s',
        'Tour %s 2025',
        '%s en Vivo',
        '%s World Tour',
        'Conferencia %s',
        'Seminario %s',
        'Workshop %s',
    ];

    private array $artists = [
        'Rock Legends',
        'Jazz Masters',
        'Indie Sounds',
        'Electronic Beats',
        'Classical Symphony',
        'Latin Fusion',
        'Pop Stars',
        'Metal Thunder',
        'Hip Hop Nation',
        'Folk Acoustic',
    ];

    private array $venues = [
        'Estadio Nacional',
        'Teatro Municipal',
        'Arena Central',
        'Parque de la Ciudad',
        'Centro de Convenciones',
        'Auditorio Principal',
        'Plaza Mayor',
        'Coliseo Metropolitano',
    ];

    public function definition(): array
    {
        $totalTickets = fake()->randomElement([100, 250, 500, 1000, 2500, 5000]);
        $reservedTickets = fake()->numberBetween(0, (int) ($totalTickets * 0.3));
        $soldTickets = fake()->numberBetween(0, (int) ($totalTickets * 0.5));
        $availableTickets = $totalTickets - $reservedTickets - $soldTickets;

        return [
            'name' => sprintf(
                fake()->randomElement($this->eventTypes),
                fake()->randomElement($this->artists)
            ),
            'description' => fake()->paragraphs(2, true),
            'event_date' => fake()->dateTimeBetween('+1 week', '+6 months'),
            'location' => fake()->randomElement($this->venues).', '.fake()->city(),
            'total_tickets' => $totalTickets,
            'available_tickets' => $availableTickets,
            'reserved_tickets' => $reservedTickets,
            'price_per_ticket' => fake()->randomElement([29.99, 49.99, 79.99, 99.99, 149.99, 199.99]),
            'reservation_ttl_minutes' => config('reservationFlow.reservation_ttl_minutes', 2),
            'status' => EventStatus::ACTIVE,
        ];
    }

    public function soldOut(): static
    {
        return $this->state(fn (array $attributes): array => [
            'available_tickets' => 0,
            'reserved_tickets' => 0,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => EventStatus::CANCELLED,
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'event_date' => fake()->dateTimeBetween('-3 months', '-1 day'),
            'status' => EventStatus::COMPLETED,
            'available_tickets' => 0,
            'reserved_tickets' => 0,
        ]);
    }

    public function withHighAvailability(): static
    {
        return $this->state(function (array $attributes): array {
            $total = $attributes['total_tickets'];

            return [
                'available_tickets' => (int) ($total * 0.9),
                'reserved_tickets' => (int) ($total * 0.05),
            ];
        });
    }

    public function withLowAvailability(): static
    {
        return $this->state(function (array $attributes): array {
            return [
                'available_tickets' => fake()->numberBetween(1, 10),
                'reserved_tickets' => fake()->numberBetween(0, 5),
            ];
        });
    }

    public function premium(): static
    {
        return $this->state(fn (array $attributes): array => [
            'price_per_ticket' => fake()->randomElement([299.99, 499.99, 799.99]),
            'total_tickets' => fake()->randomElement([50, 100, 200]),
        ]);
    }
}
