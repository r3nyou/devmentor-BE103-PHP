<?php

namespace App\Http\Repositories;

use App\Models\Event;
use App\Models\EventNotifyChannel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventRepository
{
    public function create(array $input)
    {
        DB::beginTransaction();
        try {
            $event = new Event();
            $event->name = $input['name'];
            $event->trigger_time = Carbon::parse($input['trigger_time']);
            $event->save();

            $eventNotifyChannels = [];
            foreach ($input['event_notify_channels'] as $eventNotifyChannelId) {
                $eventNotifyChannel = new EventNotifyChannel();
                $eventNotifyChannel->notify_channel_id = $eventNotifyChannelId;
                $eventNotifyChannel->message = 'test';
                $eventNotifyChannels[] = $eventNotifyChannel;
            }

            $event->eventNotifyChannels()->saveMany($eventNotifyChannels);

            DB::commit();

            return $event;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
