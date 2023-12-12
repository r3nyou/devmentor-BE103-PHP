<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all();

        return response()->json($events->all());
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'trigger_time'
        ]);
        Event::create($data);

        $event = new Event;
        $event->name = $request->name;
        $event->trigger_time = $request->trigger_time;
        $event->save();

        return response()->json(['status' => 'OK']);
    }

    public function show(string $id)
    {
        $event = Event::find($id);

        return response()->json([
            'id' => $event->id,
            'name' => $event->name,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $event = Event::find($id);

        $event->name = $request->name;
        $event->trigger_time = $request->trigger_time;

        $event->save();
    }
}

