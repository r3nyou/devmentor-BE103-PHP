<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function hello()
    {
        return response()->json(['message' => 'Hello World from controller!']);
    }

    public function index()
    {
        $eventA = new \stdClass();
        $eventA->name = 'Event A';
        $eventA->trigger_time = now();

        $eventB = new \stdClass();
        $eventB->name = 'Event B';
        $eventB->trigger_time = now();

        $events = [$eventA, $eventB];

        return response()->json($events);
    }

    public function create(Request $request)
    {
        $event = new \stdClass();
        $event->name = $request->name;
        $event->trigger_time = $request->trigger_time;

        return response()->json($event);
    }

    public function update($id, Request $request)
    {
        $eventA = new \stdClass();
        $eventA->name = 'Event A';
        $eventA->trigger_time = now();

        $eventB = new \stdClass();
        $eventB->name = 'Event B';
        $eventB->trigger_time = now();

        $events = [
            '1' => $eventA,
            '2' => $eventB
        ];

        if (isset($events[$id])) {
            $updateEvent = $events[$id];
            $updateEvent->name = $request->name;
            $updateEvent->trigger_time = $request->trigger_time;
        }

        return response()->json($events);
    }
}
