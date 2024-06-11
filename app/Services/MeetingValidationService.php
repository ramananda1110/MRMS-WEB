<?php
namespace App\Services;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MeetingValidationService
{
    public function validateMeeting($request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'meeting_title' => 'required|string|max:255',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:09:00',
                'before_or_equal:17:15',
                function ($attribute, $value, $fail) use ($request) {
                    $currentTime = Carbon::now('Asia/Dhaka');
                    $startDate = Carbon::parse($request->input('start_date'));

                    if ($startDate->format('Y-m-d') === $currentTime->format('Y-m-d')) {
                        $validStartTime = $currentTime->copy()->addMinutes(30);
                        $startTime = Carbon::parse($value, 'Asia/Dhaka')->setTimezone('UTC');

                        if ($startTime < $validStartTime) {
                            $fail('The start time must be at least 30 minutes after the current time.');
                        }
                    }
                }
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
                'after_or_equal:09:00',
                'before_or_equal:17:30',
            ],
            'host_id' => 'required|exists:employees,employee_id',
            'co_host_id' => 'nullable|exists:employees,employee_id',
            'participants' => 'required|array',
        ]);

        $validator->after(function ($validator) use ($request) {
            $room_id = $request->input('room_id');
            $start_date = $request->input('start_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');

            $startDateTime = \DateTime::createFromFormat('H:i', $start_time);
            $startDateTime->add(new \DateInterval('PT1M'));
            $updated_start_time = $startDateTime->format('H:i');

            $overlappingMeeting = Meeting::where('room_id', $room_id)
                ->where('start_date', $start_date)
                ->where('booking_status', '!=', 'rejected')
                ->where(function ($query) use ($updated_start_time, $end_time) {
                    $query->whereBetween('start_time', [$updated_start_time, $end_time])
                        ->orWhereBetween('end_time', [$updated_start_time, $end_time])
                        ->orWhere(function ($query) use ($updated_start_time, $end_time) {
                            $query->where('start_time', '<', $updated_start_time)
                                  ->where('end_time', '>', $end_time);
                        });
                })
                ->exists();

            if ($overlappingMeeting) {
                $validator->errors()->add('overlap', 'There is already a meeting scheduled at this time.');
            }
        });

        return $validator;
    }
}

