<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'event_date' => $this->event_date->toIso8601String(),
            'location' => $this->location,
            'total_tickets' => $this->total_tickets,
            'available_tickets' => $this->available_tickets,
            'reserved_tickets' => $this->reserved_tickets,
            'price_per_ticket' => $this->price_per_ticket,
            'reservation_ttl_minutes' => $this->reservation_ttl_minutes,
            'status' => $this->status->value,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
