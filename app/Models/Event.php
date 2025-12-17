<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\EventStatus;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'location',
        'total_tickets',
        'available_tickets',
        'reserved_tickets',
        'price_per_ticket',
        'reservation_ttl_minutes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
            'price_per_ticket' => 'decimal:2',
            'status' => EventStatus::class,
        ];
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
