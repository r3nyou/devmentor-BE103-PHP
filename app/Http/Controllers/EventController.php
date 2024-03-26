<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
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

        return response()->json(['status' => 'OK']);
    }
}

