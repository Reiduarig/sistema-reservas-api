<?php

namespace App\Actions\Cart\AddItemToCart;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Actions\Cart\AddItemToCartPassable;
use App\Enums\EventStatus;
use Closure;
use Illuminate\Validation\ValidationException;

class ValidateEventAvailabilityPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly EventRepositoryInterface $eventRepository,
    ) {}

    /**
     * Handle the passable.
     */
    public function handle(AddItemToCartPassable $passable, Closure $next): mixed
    {
        $passable->event = $this->eventRepository->findById(
            $passable->data->eventId,
        );

        if (! $passable->event instanceof \App\Models\Event) {
            throw ValidationException::withMessages([
                'event_id' => ['The selected event does not exist.'],
            ]);
        }

        if ($passable->event->status !== EventStatus::ACTIVE) {
            throw ValidationException::withMessages([
                'event_id' => ['Event is not active.'],
            ]);
        }

        if( $passable->event->available_tickets < $passable->data->quantity ) {
            throw ValidationException::withMessages([
                'quantity' => ['Not enough tickets for this event.'],
            ]);
        }

        return $next($passable);
    }
}
