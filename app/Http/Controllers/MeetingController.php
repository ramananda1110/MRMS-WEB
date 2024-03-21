<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Participant;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            // Retrieve all meetings with participants
       $meetings = Meeting::with('participants')->get();

        //$meetings = Meeting::with(['participants.employee', 'host', 'coHost'])->get();

        // Transform the meetings data to include participant names
        $data = $meetings->map(function ($meeting) {
            return [
                'id' => $meeting->id,
                'room_id' => $meeting->room_id,
                'room_name' => $meeting->room->name,
                'room_facilities' => $meeting->room->facilities,
                'meeting_title' => $meeting->meeting_title,
                'start_date' => $meeting->start_date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_id' => $meeting->host_id,
                'host_name' => $meeting->host ? $meeting->host->name : null,
                'co_host_id' => $meeting->co_host_id,
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : null,
                'booking_type' => $meeting->booking_type,
                'booking_status' => $meeting->booking_status,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                'participants' => $meeting->participants->map(function ($participant) {
                    return [
                        'id' => $participant->id,
                        'meeting_id' => $participant->meeting_id,
                        'participant_id' => $participant->participant_id,
                        'participant_name' => $participant->employee ? $participant->employee->name : null,
                        'created_at' => $participant->created_at,
                        'updated_at' => $participant->updated_at,
                    ];
                }),
            ];
        });
       
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);

            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    
    
    public function store(Request $request)
    {

      $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'meeting_title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:00' // Start time must be before or equal to 17:00 (5:00 PM)
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // End time must be after the start time
                'after_or_equal:09:00', // End time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:00' // End time must be before or equal to 17:00 (5:00 PM)
            ],
            'host_id' => 'required|exists:employees,employee_id',
            'co_host_id' => 'nullable|exists:employees,employee_id',
            'participants' => 'required|array', // Ensure participants is an array and required
        ]);
        
        // Add custom validation rule to check for overlapping meetings
        $validator->after(function ($validator) use ($request) {
            // Retrieve input data
            $room_id = $request->input('room_id');
            $start_date = $request->input('start_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');
        
            // Check for overlapping meetings
            $overlappingMeeting = Meeting::where('room_id', $room_id)
                ->where('start_date', $start_date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($query) use ($start_time, $end_time) {
                            $query->where('start_time', '<', $start_time)
                                    ->where('end_time', '>', $end_time);
                        });
                })
                ->exists();
        
            // If overlapping meeting found, add error message
            if ($overlappingMeeting) {
                $validator->errors()->add('overlap', 'There is already a meeting scheduled at this time.');
            }
        });
        


            // If validation fails, return a custom response
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status_code' => 422
            ], 200);
        }

        // If validation passes, create the meeting using the validated data
        $meeting = Meeting::create($validator->validated());


       //dd($participants);
      
        // Attach participants to the meeting
        if ($request->has('participants')) {
            foreach ($request->participants as $participantId) {
                // Create a new participant record
                Participant::create([
                    'meeting_id' => $meeting->id,
                    'participant_id' => $participantId
                ]);
            }
        }

       
        // Return a success response with the created meeting
            return response()->json([
                'message' => 'Meeting created successfully',
                'meeting' => $meeting,
            ], 201);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


