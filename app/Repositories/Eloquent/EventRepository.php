<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Collection;

class EventRepository implements EventRepositoryInterface
{
    public function findById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function findByIdWithLock(int $id): ?Event
    {
        return Event::lockForUpdate()->find($id);
    }

    public function findActive(): Collection
    {
        return Event::query()
            ->where('status', EventStatus::ACTIVE)
            ->where('event_date', '>', now())
            ->orderBy('event_date')
            ->get();
    }

    public function save(Event $event): bool
    {
        return $event->save();
    }
}
