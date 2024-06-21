<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventController extends Controller{

    public function hello()
    {
        return response()->json(['message' => 'Hello World from controller!']);
    }
    public function index()
    {
        $events = Event::all(); 
        // $eventA = new \stdClass();
        // $eventA->name = 'Event A';
        // $eventA->trigger_time = now();

        // $eventB = new \stdClass();
        // $eventB->name = 'Event B';
        // $eventB->trigger_time = now();

        // $events = [$eventA, $eventB];

        return response()->json($events);
    }
    public function create(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->trigger_time = $request->trigger_time;
        $event->save();

        return response()->json($event);
    }

    public function update($id, Request $request)
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $th) {
            return response()->json(['message' => 'event not found'], 404);
        }
        $event->name = $request->name;
        $event->trigger_time = $request->trigger_time;
        $event->save();
    
    
                      
        // $eventA = new \stdClass();
        // $eventA->name = 'Event A';
        // $eventA->trigger_time = now();

        // $eventB = new \stdClass();
        // $eventB->name = 'Event B';
        // $eventB->trigger_time = now();

        // $events = [
        //     '1' => $eventA,
        //     '2' => $eventB
        // ];

        // if (isset($events[$id])) {
        //     $updateEvent = $events[$id];
        //     $updateEvent->name = $request->name;
        //     $updateEvent->trigger_time = $request->trigger_time;
        // }

        return response()->json($event);
    }
    public function show($id, Request $request)
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $th) {
            return response()->json(['message' => 'event not found'], 404);
        }
        return response()->json($event);
    }
    public function delete($id, Request $request)
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $th) {
            return response()->json(['message' => 'event not found'], 404);
        }
        $event->delete();
    }
}