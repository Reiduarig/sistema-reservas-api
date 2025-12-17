<?php

namespace App\Repositories\Contracts;

use App\Models\Event;
use Illuminate\Support\Collection;

interface EventRepositoryInterface
{
    public function findById(int $id): ?Event;

    public function findByIdWithLock(int $id): ?Event;

    public function findActive(): Collection;

    public function save(Event $event): bool;
}
