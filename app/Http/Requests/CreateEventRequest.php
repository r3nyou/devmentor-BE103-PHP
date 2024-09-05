<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'trigger_time' => 'required|date_format:Y-m-d H:i:s',
            'event_notify_channels' => 'required|array',
            'event_notify_channels.*' => 'integer|exists:notify_channels,id',
        ];
    }
}
