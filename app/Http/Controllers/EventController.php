<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Services\EventService;
use App\Http\Transformer\GetEventsTransformer;
use App\Models\Event;
use App\Models\EventNotifyChannel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * @var EventService
     */
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function hello()
    {
        return response()->json(['message' => 'Hello World from controller!']);
    }

    public function index(GetEventsTransformer $transformer)
    {
        $events = Event::with('eventNotifyChannels')->get();

        $response = $transformer->transform($events);

        return response()->json($response);
    }

    public function get($id)
    {
        $event = Event::findOrFail($id);

        $response = [
            'id' => $event->id,
            'name' => $event->name,
            'trigger_time' => $event->trigger_time,
            'event_notify_channels' => $event->eventNotifyChannels->pluck('notify_channel_id'),
        ];
        return response()->json($response);
    }

    public function create(CreateEventRequest $request)
    {
        $event = $this->eventService->create($request->all());

        return response()->json($event);
    }

    public function update($id, UpdateEventRequest $request)
    {
        DB::beginTransaction();
        try {
            $updateEvent = Event::where('id', $id)->firstOrFail();
            if (null !== $request->name) {
                $updateEvent->name = $request->name;
            }
            $updateEvent->trigger_time = Carbon::parse($request->trigger_time);
            $updateEvent->save();

            if (null !== $request->event_notify_channels) {
                $updateEvent->eventNotifyChannels()->delete();

                $eventNotifyChannels = [];
                foreach ($request->event_notify_channels as $eventNotifyChannelId) {
                    $eventNotifyChannel = new EventNotifyChannel();
                    $eventNotifyChannel->notify_channel_id = $eventNotifyChannelId;
                    $eventNotifyChannel->message = 'test';
                    $eventNotifyChannels[] = $eventNotifyChannel;
                }

                $updateEvent->eventNotifyChannels()->saveMany($eventNotifyChannels);
            }

            DB::commit();

            return response()->json($updateEvent);
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
