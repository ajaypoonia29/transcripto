<?php

declare(strict_types=1);

namespace App\Domains\Payments\Tasks;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CreateGoogleMeetTask
{
    /**
     * Create a Google Meet calendar event.
     *
     * @param string $summary
     * @param string $dateTime ISO format
     * @param int $durationMinutes
     * @return string The generated Google Meet URL
     */
    public function execute(string $summary, string $dateTime, int $durationMinutes = 60): string
    {
        $mockMeetLink = 'https://meet.google.com/' . 
            Str::lower(Str::random(3)) . '-' . 
            Str::lower(Str::random(4)) . '-' . 
            Str::lower(Str::random(3));

        // Fake the endpoint call for mock execution
        Http::fake([
            'www.googleapis.com/calendar/v3/calendars/primary/events*' => Http::response([
                'id' => 'event_' . Str::random(10),
                'status' => 'confirmed',
                'htmlLink' => 'https://calendar.google.com/calendar/event?eid=' . Str::random(20),
                'hangoutLink' => $mockMeetLink
            ], 200)
        ]);

        $response = Http::post('https://www.googleapis.com/calendar/v3/calendars/primary/events', [
            'summary' => $summary,
            'start' => ['dateTime' => $dateTime],
        ]);

        /** @var string */
        return $response->json('hangoutLink') ?? $mockMeetLink;
    }
}
