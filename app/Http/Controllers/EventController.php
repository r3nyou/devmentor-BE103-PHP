<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventNotifyChannel;
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

        $response = [];
        foreach ($events as $event) {
            $eventNotifyChannelIds = [];
            foreach ($event->eventNotifyChannels as $eventNotifyChannel) {
                $eventNotifyChannelIds[] = $eventNotifyChannel->notify_channel_id;
            }

            $response[] = [
                'id' => $event->id,
                'name' => $event->name,
                'trigger_time' => $event->trigger_time,
                'event_notify_channels' => $eventNotifyChannelIds,
            ];
        }

        return response()->json($response);
    }

    public function get($id)
    {
        $event = Event::find($id);

        $eventNotifyChannelIds = [];
        foreach ($event->eventNotifyChannels as $eventNotifyChannel) {
            $eventNotifyChannelIds[] = $eventNotifyChannel->notify_channel_id;
        }

        $response = [
            'id' => $event->id,
            'name' => $event->name,
            'trigger_time' => $event->trigger_time,
            'event_notify_channels' => $eventNotifyChannelIds,
        ];
        return response()->json($response);
    }

    public function create(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->trigger_time = Carbon::parse($request->trigger_time);
        $event->save();

        $eventNotifyChannels = [];
        foreach ($request->event_notify_channels as $eventNotifyChannelId) {
            $eventNotifyChannel = new EventNotifyChannel();
            $eventNotifyChannel->notify_channel_id = $eventNotifyChannelId;
            $eventNotifyChannel->message = 'test';
            $eventNotifyChannels[] = $eventNotifyChannel;
        }

        $event->eventNotifyChannels()->saveMany($eventNotifyChannels);

        return response()->json($event);
    }

    public function update($id, Request $request)
    {
        $updateEvent = Event::where('id', $id)->first();
        $updateEvent->name = $request->name;
        $updateEvent->trigger_time = Carbon::parse($request->trigger_time);
        $updateEvent->save();

        $updateEvent->eventNotifyChannels()->delete();

        $eventNotifyChannels = [];
        foreach ($request->event_notify_channels as $eventNotifyChannelId) {
            $eventNotifyChannel = new EventNotifyChannel();
            $eventNotifyChannel->notify_channel_id = $eventNotifyChannelId;
            $eventNotifyChannel->message = 'test';
            $eventNotifyChannels[] = $eventNotifyChannel;
        }

        $updateEvent->eventNotifyChannels()->saveMany($eventNotifyChannels);

        return response()->json($updateEvent);
    }
}
