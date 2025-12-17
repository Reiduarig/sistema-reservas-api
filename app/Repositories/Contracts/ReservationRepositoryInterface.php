<?php

namespace App\Repositories\Contracts;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    public function findById(int $id): ?Reservation;

    public function findByIdForUser(int $id, int $userId): ?Reservation;

    public function findByUser(int $userId): Collection;

    public function findExpired(): Collection;

    public function save(Reservation $reservation): bool;
}
