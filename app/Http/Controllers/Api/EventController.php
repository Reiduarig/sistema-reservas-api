<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\EventResource;

class EventController extends Controller
{

    public function __construct(
        private readonly EventRepositoryInterface $eventRepository
    ) {}

    /**
     * Listar todos los eventos activos.
     */
    public function index(): AnonymousResourceCollection
    {
        $events = $this->eventRepository->findActive();

        return EventResource::collection($events);
    }

    /**
     * Mostrar los detalles de un evento específico.
     */
    public function show(int $id): EventResource
    {
        $event = $this->eventRepository->findById($id);

        abort_if(!$event, 404, 'Event not found.');

        return new EventResource($event);
    }
    
}
