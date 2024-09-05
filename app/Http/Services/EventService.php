<?php

namespace App\Http\Services;

use App\Http\Repositories\EventRepository;

class EventService
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function create(array $input)
    {
        return $this->eventRepository->create($input);
    }
}
