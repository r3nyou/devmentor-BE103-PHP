<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function hello()
    {
        return response()->json(['message' => 'Hello World from controller!']);
    }

    public function index()
    {
        $events = Event::all();

        return response()->json($events);
    }

    public function get($id)
    {
        $event = Event::find($id);

        return response()->json($event);
    }

    public function create(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->trigger_time = Carbon::parse($request->trigger_time);
        $event->save();

        return response()->json($event);
    }

    public function update($id, Request $request)
    {
        $updateEvent = Event::where('id', $id)->first();
        $updateEvent->name = $request->name;
        $updateEvent->trigger_time = Carbon::parse($request->trigger_time);
        $updateEvent->save();

        return response()->json($updateEvent);
    }
}
