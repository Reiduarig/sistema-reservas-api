<?php

namespace App\Repositories\Eloquent;
use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\ReservationRepositoryInterface;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function findById(int $id): ?Reservation
    {
        return Reservation::with('event')->find($id);
    }

    public function findByIdForUser(int $id, int $userId): ?Reservation
    {
        return Reservation::with('event')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function findByUser(int $userId): Collection
    {
        return Reservation::with('event')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findExpired(): Collection
    {
        return Reservation::with('event')
            ->where('status', ReservationStatus::PENDING)
            ->where('expires_at', '<', now())
            ->get();
    }

    public function save(Reservation $reservation): bool
    {
        return $reservation->save();
    }
}
