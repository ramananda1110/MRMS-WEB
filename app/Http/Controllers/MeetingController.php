<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Participant;
use DataTables;
use App\Http\Controllers\FCMPushController;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\MeetingDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $notificationController;

     public function __construct(FCMPushController $notificationController)
     {
         $this->notificationController = $notificationController;
     }


     public function index()
     {
        
        // Retrieve the authenticated user's employee ID and role ID
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;

        // Fetch meetings based on user role
        $meetingsQuery = Meeting::with('participants');
        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();

        // Update booking status based on conditions
        $today = now()->toDateString();
        foreach ($meetings as $meeting) {
            $status = $meeting->booking_status;
            $startDate = $meeting->start_date;

            switch ($status) {
                case 'pending':
                    if ($startDate < $today) {
                        $status = 'canceled';
                    }
                    break;
                case 'accepted':
                    if ($startDate < $today) {
                        $status = 'completed';
                    } else {
                        $status = 'upcoming';
                    }
                    break;
                case 'rejected':
                    $status = 'canceled';
                    break;
            }

            // Update the meeting status
            $meeting->booking_status = $status;
        }

         // Order meetings by latest start_date
        $meetings = $meetings->sortByDesc('start_date')->values()->all();
   
        
        //dd($meetings);

        return view('admin.meeting.index', compact('meetings'));

     }

    public function upcoming(Request $request)
    {
        
         // Retrieve the authenticated user's employee ID and role ID
         $employeeId = Auth()->user()->employee_id;
         $roleId = Auth()->user()->role_id;
 
         // Fetch meetings based on user role
         $meetingsQuery = Meeting::with('participants');
         if ($roleId !== 1) {
             $meetingsQuery->where(function ($query) use ($employeeId) {
                 $query->where('host_id', $employeeId)
                     ->orWhereHas('participants', function ($query) use ($employeeId) {
                         $query->where('participant_id', $employeeId);
                     });
             });
         }
 
         $meetings = $meetingsQuery->get();
 

        // Determine today's date
        $today = now()->toDateString();

        // Filter meetings and calculate statuses
        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'accepted' && $meeting->start_date >= $today;
        });

    
        return view('admin.meeting.upcoming', compact('meetings'));
    }

    public function pending()
    {
         // Retrieve the authenticated user's employee ID and role ID
         $employeeId = Auth()->user()->employee_id;
         $roleId = Auth()->user()->role_id;
 
         // Fetch meetings based on user role
         $meetingsQuery = Meeting::with('participants');
         if ($roleId !== 1) {
             $meetingsQuery->where(function ($query) use ($employeeId) {
                 $query->where('host_id', $employeeId)
                     ->orWhereHas('participants', function ($query) use ($employeeId) {
                         $query->where('participant_id', $employeeId);
                     });
             });
         }
 
         $meetings = $meetingsQuery->get();
 

        // Determine today's date
        $today = now()->toDateString();


        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'pending' && $meeting->start_date >= $today;
        });

        return view('admin.meeting.pending', compact('meetings'));
    }


    public function cenceled()
    {

        // Retrieve the authenticated user's employee ID and role ID
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;

        // Fetch meetings based on user role
        $meetingsQuery = Meeting::with('participants');
        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();

        $today = now()->toDateString();


        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'rejected' || $meeting->booking_status === 'pending' && $meeting->start_date < $today;
        });


        return view('admin.meeting.canceled', compact('meetings'));
    }


    public function completed()
    {
       // Retrieve the authenticated user's employee ID and role ID
       $employeeId = Auth()->user()->employee_id;
       $roleId = Auth()->user()->role_id;

       // Fetch meetings based on user role
       $meetingsQuery = Meeting::with('participants');
       if ($roleId !== 1) {
           $meetingsQuery->where(function ($query) use ($employeeId) {
               $query->where('host_id', $employeeId)
                   ->orWhereHas('participants', function ($query) use ($employeeId) {
                       $query->where('participant_id', $employeeId);
                   });
           });
       }

       $meetings = $meetingsQuery->get();


        // Determine today's date
        $today = now()->toDateString();

        $meetings = $meetings->filter(function ($meeting) use ($today) {
            return $meeting->booking_status === 'accepted' && $meeting->start_date < $today;
        });

        return view('admin.meeting.index', compact('meetings'));
    }


     // get all meeting for Mobile App
    public function getAllMeetins(Request $request)
    {
       // Retrieve the employee ID from the request query
        $employeeId = $request->query('employee_id');

        // Retrieve the user based on the employee ID
        $user = User::where('employee_id', $employeeId)->first();

        // Initialize the meetings query
        $meetingsQuery = Meeting::with('participants');

        // Check if the user exists and is an admin (role_id = 1)
        if ($user && $user->role_id !== 1) {
            // For non-admin users, add additional conditions to the query
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        // Execute the query to get the meetings
         $meetings = $meetingsQuery->get();

        $data = $meetings->map(function ($meeting) {

            // Determine the status based on conditions
            $status = $meeting->booking_status;
            $today = now()->toDateString();
            $startDate = $meeting->start_date;

            if ($status === 'pending') {
                if ($startDate < $today) {
                    $status = 'canceled';
                } 
            } elseif ($status === 'accepted') {
                if ($startDate < $today) {
                    $status = 'completed';
                } else {
                    $status = 'upcoming';
                }
            } elseif ($status === 'rejected') {
                    $status = 'canceled';
            } 

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
                'host_name' => $meeting->host ? $meeting->host->name : '',
                'co_host_id' => $meeting->co_host_id ? $meeting->co_host_id : 0,
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : "New",
                'booking_type' => $meeting->booking_type,
                'booking_status' => $status,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                'participants' => $meeting->participants->map(function ($participant) {
                    return [
                        'id' => $participant->id,
                        'meeting_id' => $participant->meeting_id,
                        'participant_id' => $participant->participant_id,
                        'participant_name' => $participant->employee ? $participant->employee->name : '',
                        'division' => $participant->employee ? $participant->employee->division : '',
                        'designation' => $participant->employee ? $participant->employee->designation : '',
                        'created_at' => $participant->created_at,
                        'updated_at' => $participant->updated_at,
                    ];
                }),
            ];
        });
       
         // Order meetings by latest start_date
        $data = $data->sortByDesc('start_date')->values()->all();
   
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
        return view('admin.meeting.create');

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
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ensure start date is after or equal to today
            ],
            // 'start_time' => [
            //     'required',
            //     'date_format:H:i',
            //     'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
            //     'before_or_equal:17:30' // Start time must be before or equal to 17:30 (5:00 PM)
            // ],


            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:15', // Start time must be before or equal to 17:00 (5:00 PM)
                function ($attribute, $value, $fail) use ($request) {
                   
                   // Get the current date and time in Bangladesh Standard Time (Asia/Dhaka)
                    $currentTime = Carbon::now('Asia/Dhaka');
                    // info('Current Time:', ['current_time' => $currentTime]);

                    // Parse the provided start_date
                    $startDate = Carbon::parse($request->input('start_date'));

                    // Check if the user-provided start date is today
                    if ($startDate->format('Y-m-d') === $currentTime->format('Y-m-d')) {
                        // Today's date: Perform time validation

                        // Add 30 minutes to the current time
                        $validStartTime = $currentTime->copy()->addMinutes(30);
                        //info('Valid Start Time:', ['valid_start_time' => $validStartTime]);

                        // Convert start_time to a DateTime object in UTC
                        $startTime = Carbon::parse($value, 'Asia/Dhaka')->setTimezone('UTC');
                        //info('Start Time:', ['start_time' => $startTime]);

                        if ($startTime < $validStartTime) {
                            $fail('The start time must be at least 30 minutes after the current time.');
                        }
                    }
                }
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // End time must be after the start time
                'after_or_equal:09:00', // End time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:30' // End time must be before or equal to 17:30 (5:00 PM)
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

        
           // Convert start_time to a DateTime object
           $startDateTime = \DateTime::createFromFormat('H:i', $start_time);
           // Add 1 minute
           $startDateTime->add(new \DateInterval('PT1M'));
           // Format the updated start time as a string
           $updated_start_time = $startDateTime->format('H:i');
          

            // Check for overlapping meetings
            $overlappingMeeting = Meeting::where('room_id', $room_id)
                ->where('start_date', $start_date)
                ->where('booking_status', '!=', 'rejected') // New condition
                ->where(function ($query) use ($updated_start_time, $end_time) {
                    $query->whereBetween('start_time', [$updated_start_time, $end_time])
                        ->orWhereBetween('end_time', [$updated_start_time, $end_time])
                        ->orWhere(function ($query) use ($updated_start_time, $end_time) {
                            $query->where('start_time', '<', $updated_start_time)
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
          return  redirect()->back()->with('error', $validator->errors()->first()); 
        
        }
        

        // If validation passes, create the meeting using the validated data
        $meeting = Meeting::create($validator->validated());

       
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


        // sent the notification to user admin
        $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();

        $this->notificationController->attemtNotification($devicesToken, "Created a Meeting", "Requested to you a meeting schedule.");

        
        return redirect()->route("meeting.index")->with('message', 'Meeting created successfully');


    }




    public function getMeetingsByDate(Request $request)
    {
        $date = $request->query('start_date');
        $room_id = $request->input('room_id');


        // Parse the provided date string into a Carbon instance
        $parsedDate = Carbon::parse($date);

        // Retrieve meetings for the specified date
        $meetings;

        if($room_id != null) {
            $meetings = Meeting::with(['participants.employee', 'host', 'coHost'])
            ->where('room_id', $room_id)
            ->where('booking_status', '!=', 'rejected') // New condition
            ->whereDate('start_date', $parsedDate)
            ->get();
        } else {
            $meetings = Meeting::with(['participants.employee', 'host', 'coHost'])
            ->where('booking_status', '!=', 'rejected') // New condition
            ->whereDate('start_date', $parsedDate)
            ->get();
        }
       
        // Transform the meetings data (similar to the previous API endpoint)
        $data = $meetings->map(function ($meeting) {
            return [
                'id' => $meeting->id,
                'room_id' => $meeting->room_id,
                'room_name' => $meeting->room->name,
                'room_location' => $meeting->room->location,
                'meeting_title' => $meeting->meeting_title,
                'start_date' => $meeting->start_date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'host_id' => $meeting->host_id,
                'host_name' => $meeting->host ? $meeting->host->name : "",
                'co_host_id' => $meeting->co_host_id ?  $meeting->co_host_id : 0,
                'co_host_name' => $meeting->coHost ? $meeting->coHost->name : "",
                'booking_type' => $meeting->booking_type,
                'booking_status' => $meeting->booking_status,
                'created_at' => $meeting->created_at,
                'updated_at' => $meeting->updated_at,
                
            ];
        });

        // Return the JSON response
        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);
    }

   

    public function dashboardMeetingCount() {
        $today = Carbon::today();

        $totalMeeting = Meeting::all()->count();

        $upcomingCount = Meeting::where('booking_status', 'accepted')
        ->whereDate('start_date', '>=', $today) // Start date on or after today
        ->count();

        //$upcomingCount = 100;
       

        $pendingCount = Meeting::where('booking_status', 'pending')->count();

       // $pendingCount = 90;

        $completedCount = Meeting::where('booking_status', 'accepted')
        ->whereDate('start_date', '<', $today) // Start date before today
        ->count();
    
       // $completedCount = 244;

       $weekendData = [
        'Sunday' => 10,
        'Monday' => 12,
        'Tuesday' => 9,
        'Wednesday' => 30,
        'Thursday' => 25,
        'Friday' => 10,
        'Saturday' => 7,
        ];

        $yearlyData = [
            'Jan' => 90,
            'Feb' => 122,
            'Mar' => 90,
            'Apr' => 30,
            'May' => 70,
            'Jun' => 80,
            'Jul' => 7,
            'Aug' => 6,
            'Sep' => 3,
            'Oct' => 7,
            'Nov' => 43,
            'Dec' => 10
            ];

       // dd($weekendData);

        return view('welcome', compact('totalMeeting', 'upcomingCount', 'pendingCount', 'completedCount', 'weekendData', 'yearlyData'));

    }

   

    public function getSummary()
    {
    
            // Get today's date
        $today = Carbon::today();

        // Get count of meetings with different statuses
        $upcomingCount = Meeting::where('booking_status', 'accepted')
            ->whereDate('start_date', '>=', $today) // Start date on or after today
            ->count();

        $pendingCount = Meeting::where('booking_status', 'pending')->count();

        $completedCount = Meeting::where('booking_status', 'accepted')
            ->whereDate('start_date', '<', $today) // Start date before today
            ->count();

        // Total meeting count
        $totalMeetingCount = Meeting::count();


        
        // Get the start date of the current week (Sunday)
        $startOfWeek = Carbon::now()->startOfWeek()->subDay()->format('Y-m-d');

        // Get the end date of the current week (Saturday)
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        // Get count of meetings for the current week
        $meetings = Meeting::whereBetween('start_date', [$startOfWeek, $endOfWeek])->get();


        // dd($meetings->count);

        // Initialize the weekend data array
        $weekendData = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
        ];

        foreach ($meetings as $meeting) {
            // Extract the day of the week from the start date
            $weekDay = Carbon::parse($meeting->start_date)->format('l');
    
            // Increment the count for the respective day of the week
            $weekendData[$weekDay]++;
        }
    
        // Return the summary data
        $data = [
            'total_meeting' => $totalMeetingCount,
            'upcoming' => $upcomingCount,
            'pending' => $pendingCount,
            'completed' => $completedCount,
            'weekly_schedule' => $weekendData,
        ];

        return response()->json([
            'status_code' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Success'
        ]);
    }
    
    
    public function updateMeetingStatus(Request $request, $id)
    {

       // Validate the incoming request data
       $validator = Validator::make($request->all(), [
        'booking_status' => 'required|in:accepted,completed,rejected',
       // 'booking_type' => 'required|in:booked,rescheduled',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = implode('. ', $errors);
            return response()->json(['status_code' => 422, 'message' => $message], 200);
        }

         // Find the meeting record by ID
        $meeting = Meeting::find($id);

        // Check if the meeting exists
        if (!$meeting) {
            return response()->json(['status_code' => 404, 'message' => 'Meeting not found'], 200);
        }

        // Update the meeting record with the validated data
        $meeting->update([
            'booking_status' => $request->booking_status,
        ]
       );


        // sent the notification to user host and co-host
      
       $hostId = $meeting->host_id;
       $coHostId = $meeting->co_host_id;

       $users = User::whereIn('employee_id', [$hostId, $coHostId])->get();

       // Extract api_tokens from the user records
       $devicesToken = $users->pluck('device_token')->toArray();
    
       $this->notificationController->attemtNotification($devicesToken, "Meeting Updated", "Your meeting has been " . $request->booking_status);
 

        // Return a success response
        return response()->json(['status_code' => 200, 'message' => 'Meeting status updated successfully']);

    }


    public function updateMeetingByWeb(Request $request, $id)
    {

       // Validate the incoming request data
       $validator = Validator::make($request->all(), [
        'booking_status' => 'required|in:accepted,completed,rejected',
       // 'booking_type' => 'required|in:booked,rescheduled',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $message = implode('. ', $errors);

            return  redirect()->back()->with('error', $message); 

        }

         // Find the meeting record by ID
        $meeting = Meeting::find($id);

        // Check if the meeting exists
        if (!$meeting) {
            return  redirect()->back()->with('error', 'Meeting not found'); 

        }

        // Update the meeting record with the validated data
        $meeting->update([
            'booking_status' => $request->booking_status,
        ]
       );


        // sent the notification to user host and co-host
      
       $hostId = $meeting->host_id;
       $coHostId = $meeting->co_host_id;

       $users = User::whereIn('employee_id', [$hostId, $coHostId])->get();

       // Extract api_tokens from the user records
       $devicesToken = $users->pluck('device_token')->toArray();
    
       $this->notificationController->attemtNotification($devicesToken, "Meeting Updated", "Your meeting has been " . $request->booking_status);
 
        // Return a success response
        return redirect()->back()->with('message', 'Meeting status updated successfully');

    }



    public function reschedule(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'room_id' => 'required|exists:rooms,id',
                'meeting_title' => 'required|string|max:255',
                'start_date' => [
                    'required',
                    'date',
                    'after_or_equal:today', // Ensure start date is after or equal to today
                ],
                // 'start_time' => [
                //     'required',
                //     'date_format:H:i',
                //     'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                //     'before_or_equal:17:15' // Start time must be before or equal to 17:00 (5:00 PM)
                // ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                    'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                    'before_or_equal:17:15', // Start time must be before or equal to 17:00 (5:00 PM)
                    function ($attribute, $value, $fail) use ($request) {
                       
                       // Get the current date and time in Bangladesh Standard Time (Asia/Dhaka)
                        $currentTime = Carbon::now('Asia/Dhaka');
                        // info('Current Time:', ['current_time' => $currentTime]);
    
                        // Parse the provided start_date
                        $startDate = Carbon::parse($request->input('start_date'));
    
                        // Check if the user-provided start date is today
                        if ($startDate->format('Y-m-d') === $currentTime->format('Y-m-d')) {
                            // Today's date: Perform time validation
    
                            // Add 30 minutes to the current time
                            $validStartTime = $currentTime->copy()->addMinutes(5);
                            //info('Valid Start Time:', ['valid_start_time' => $validStartTime]);
    
                            // Convert start_time to a DateTime object in UTC
                            $startTime = Carbon::parse($value, 'Asia/Dhaka')->setTimezone('UTC');
                            //info('Start Time:', ['start_time' => $startTime]);
    
                            if ($startTime < $validStartTime) {
                                $fail('The start time must be at least 30 minutes after the current time.');
                            }
                        }
                    }
                ],

                'end_time' => [
                    'required',
                    'date_format:H:i',
                    'after:start_time', // End time must be after the start time
                    'after_or_equal:09:00', // End time must be after or equal to 09:00 (9:00 AM)
                    'before_or_equal:17:30' // End time must be before or equal to 17:00 (5:00 PM)
                ],
                'host_id' => 'required|exists:employees,employee_id',
                'co_host_id' => 'nullable|exists:employees,employee_id',
                'participants' => 'required|array', // Ensure participants is an array and required
            ]);
            
            // Add custom validation rule to check for overlapping meetings
            $validator->after(function ($validator) use ($request, $id) {
                // Retrieve input data
                $room_id = $request->input('room_id');
                $start_date = $request->input('start_date');
                $start_time = $request->input('start_time');
                $end_time = $request->input('end_time');


                // Convert start_time to a DateTime object
                $startDateTime = \DateTime::createFromFormat('H:i', $start_time);
                // Add 1 minute
                $startDateTime->add(new \DateInterval('PT1M'));
                // Format the updated start time as a string
                $updated_start_time = $startDateTime->format('H:i');

                // Check for overlapping meetings excluding the current meeting
                $overlappingMeeting = Meeting::where('room_id', $room_id)
                    ->where('start_date', $start_date)
                    ->where('id', '!=', $id)
                    ->where(function ($query) use ($updated_start_time, $end_time) {
                        $query->whereBetween('start_time', [$updated_start_time, $end_time])
                            ->orWhereBetween('end_time', [$updated_start_time, $end_time])
                            ->orWhere(function ($query) use ($updated_start_time, $end_time) {
                                $query->where('start_time', '<', $updated_start_time)
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

            // If validation passes, update the meeting using the validated data
            $meeting = Meeting::find($id);

            // Check if the meeting exists
            if (!$meeting) {
            return response()->json(['status_code' => 404, 'message' => 'Meeting not found'], 200);
            }


            $meeting->update($validator->validated());


            $apiToken = $request->query('api_token');

            // Retrieve the user based on the employee ID
            $user = User::where('api_token', $apiToken)->first();
    
            // Check if the user exists and is an admin (role_id = 1)
            if ($user && $user->role_id === 1) {
                $meeting->update(['booking_status' => 'accepted']);
            } else {
                $meeting->update(['booking_status' => 'pending']);
            }

             // Update booking type to 'reschedule'
             $meeting->update(['booking_type' => 'reschedule']);

           

            // Update or attach participants to the meeting
            if ($request->has('participants')) {
                $meeting->updateParticipants()->sync($request->participants);
                $meeting->participants()->get()->each->touch();

            }
            
            // Return a successful response with the updated meeting
            return response()->json([
                'status_code' => 200,
                'message' => 'Meeting updated successfully',
                //'meeting' => $meeting,
            ], 200);
        }
   



    public function createMeeting(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'meeting_title' => 'required|string|max:255',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ensure start date is after or equal to today
            ],
            // 'start_time' => [
            //     'required',
            //     'date_format:H:i',
            //     'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
            //     'before_or_equal:17:30' // Start time must be before or equal to 17:30 (5:00 PM)
            // ],


            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:15', // Start time must be before or equal to 17:00 (5:00 PM)
                function ($attribute, $value, $fail) use ($request) {
                   
                   // Get the current date and time in Bangladesh Standard Time (Asia/Dhaka)
                    $currentTime = Carbon::now('Asia/Dhaka');
                    // info('Current Time:', ['current_time' => $currentTime]);

                    // Parse the provided start_date
                    $startDate = Carbon::parse($request->input('start_date'));

                    // Check if the user-provided start date is today
                    if ($startDate->format('Y-m-d') === $currentTime->format('Y-m-d')) {
                        // Today's date: Perform time validation

                        // Add 30 minutes to the current time
                        $validStartTime = $currentTime->copy()->addMinutes(30);
                        //info('Valid Start Time:', ['valid_start_time' => $validStartTime]);

                        // Convert start_time to a DateTime object in UTC
                        $startTime = Carbon::parse($value, 'Asia/Dhaka')->setTimezone('UTC');
                        //info('Start Time:', ['start_time' => $startTime]);

                        if ($startTime < $validStartTime) {
                            $fail('The start time must be at least 30 minutes after the current time.');
                        }
                    }
                }
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // End time must be after the start time
                'after_or_equal:09:00', // End time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:30' // End time must be before or equal to 17:30 (5:00 PM)
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
        
          
           
           // Convert start_time to a DateTime object
           $startDateTime = \DateTime::createFromFormat('H:i', $start_time);
           // Add 1 minute
           $startDateTime->add(new \DateInterval('PT1M'));
           // Format the updated start time as a string
           $updated_start_time = $startDateTime->format('H:i');
          

            // Check for overlapping meetings
            $overlappingMeeting = Meeting::where('room_id', $room_id)
                ->where('start_date', $start_date)
                ->where('booking_status', '!=', 'rejected') // New condition
                ->where(function ($query) use ($updated_start_time, $end_time) {
                    $query->whereBetween('start_time', [$updated_start_time, $end_time])
                        ->orWhereBetween('end_time', [$updated_start_time, $end_time])
                        ->orWhere(function ($query) use ($updated_start_time, $end_time) {
                            $query->where('start_time', '<', $updated_start_time)
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


        // sent the notification to user admin
        $devicesToken = User::where('role_id', 1)->pluck('device_token')->toArray();

        $this->notificationController->attemtNotification($devicesToken, "Created a Meeting", "Requested to you a meeting schedule.");


        // Return a success response with the created meeting
            return response()->json([
                'status_code' => 200,
                'message' => 'Meeting created successfully',
                //'meeting' => $meeting,
            ], 200);
    }


   
    public function edit($id)
    {
        $meeting = Meeting::with('participants')->find($id);
        $activeEmployees = Employee::where('status', 'active')->get();
    
        return view('admin.meeting.edit', compact('meeting', 'activeEmployees'));
    }
    


    public function update(Request $request, $id)
    
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'meeting_title' => 'required|string|max:255',
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ensure start date is after or equal to today
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
                'after_or_equal:09:00', // Start time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:15', // Start time must be before or equal to 17:00 (5:00 PM)
                function ($attribute, $value, $fail) use ($request) {
                    
                    // Get the current date and time in Bangladesh Standard Time (Asia/Dhaka)
                    $currentTime = Carbon::now('Asia/Dhaka');
                    // info('Current Time:', ['current_time' => $currentTime]);

                    // Parse the provided start_date
                    $startDate = Carbon::parse($request->input('start_date'));

                    // Check if the user-provided start date is today
                    if ($startDate->format('Y-m-d') === $currentTime->format('Y-m-d')) {
                        // Today's date: Perform time validation

                        // Add 30 minutes to the current time
                        $validStartTime = $currentTime->copy()->addMinutes(5);
                        //info('Valid Start Time:', ['valid_start_time' => $validStartTime]);

                        // Convert start_time to a DateTime object in UTC
                        $startTime = Carbon::parse($value, 'Asia/Dhaka')->setTimezone('UTC');
                        //info('Start Time:', ['start_time' => $startTime]);

                        if ($startTime < $validStartTime) {
                            $fail('The start time must be at least 30 minutes after the current time.');
                        }
                    }
                }
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // End time must be after the start time
                'after_or_equal:09:00', // End time must be after or equal to 09:00 (9:00 AM)
                'before_or_equal:17:30' // End time must be before or equal to 17:00 (5:00 PM)
            ],
            'host_id' => 'required|exists:employees,employee_id',
            'co_host_id' => 'nullable|exists:employees,employee_id',
            'participants' => 'required|array', // Ensure participants is an array and required
        ]);
        
        // Add custom validation rule to check for overlapping meetings
        $validator->after(function ($validator) use ($request, $id) {
            // Retrieve input data
            $room_id = $request->input('room_id');
            $start_date = $request->input('start_date');
            $start_time = $request->input('start_time');
            $end_time = $request->input('end_time');

           
            // Convert start_time to a DateTime object
            $startDateTime = \DateTime::createFromFormat('H:i', $start_time);
            // Add 1 minute
            $startDateTime->add(new \DateInterval('PT1M'));
            // Format the updated start time as a string
            $updated_start_time = $startDateTime->format('H:i');

            // Check for overlapping meetings excluding the current meeting
            $overlappingMeeting = Meeting::where('room_id', $room_id)
                ->where('start_date', $start_date)
                ->where('id', '!=', $id)
                ->where(function ($query) use ($updated_start_time, $end_time) {
                    $query->whereBetween('start_time', [$updated_start_time, $end_time])
                        ->orWhereBetween('end_time', [$updated_start_time, $end_time])
                        ->orWhere(function ($query) use ($updated_start_time, $end_time) {
                            $query->where('start_time', '<', $updated_start_time)
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
            return  redirect()->back()->with('error', $validator->errors()->first()); 
        }

        // If validation passes, update the meeting using the validated data
        $meeting = Meeting::find($id);

        // Check if the meeting exists
        if (!$meeting) {
        return  redirect()->back()->with('error', 'Meeting not found'); 

        }

        $meeting->update($validator->validated());

        
        // Check if the user exists and is an admin (role_id = 1)
        if (Auth()->user()->role_id === 1) {
            $meeting->update(['booking_status' => 'accepted']);
        } else {
            $meeting->update(['booking_status' => 'pending']);
        }
            // Update booking type to 'reschedule'
            $meeting->update(['booking_type' => 'reschedule']);
        

       

        // Update or attach participants to the meeting
        if ($request->has('participants')) {
            $meeting->updateParticipants()->sync($request->participants);
            $meeting->participants()->get()->each->touch();

        }
                
        return redirect()->route("meeting.index")->with('message', 'Meeting rescheduled successfully');

    }



    public function exportExcel()
    {
        return Excel::download(new MeetingDataExport, 'meetings-data.xlsx');
    }



    public function exportMeetingPdf()
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 300);

        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;


        $meetingsQuery = Meeting::with(['room', 'host', 'coHost', 'participants.employee'])
            ->select(
                'id', 
                'room_id', 
                'meeting_title', 
                'start_date', 
                'start_time', 
                'end_time', 
                'host_id', 
                'co_host_id', 
                'booking_type', 
                'booking_status', 
                'description'
            )
            ->limit(500);

        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();



        $html = '
        <html>
        <head>
            <style>
                body { font-family: sans-serif; margin: 20px; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid black; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .page-break { page-break-after: always; }
            </style>
        </head>
        <body>
            <h1>Meetings List</h1>
            <table>
                <thead>
                    <tr>
                        <th>Meeting ID</th>
                        <th>Room Name</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Host</th>
                        <th>Co-Host</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Participants</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($meetings as $meeting) {
            $participants = $meeting->participants->map(function ($participant) {
                return $participant->employee ? 
                    "{$participant->employee->name} ({$participant->employee->division})" 
                    : '';
            })->implode(', ');

            $html .= '<tr>';
            $html .= '<td>' . $meeting->id . '</td>';
            $html .= '<td>' . ($meeting->room ? $meeting->room->name : 'N/A') . '</td>';
            $html .= '<td>' . $meeting->meeting_title . '</td>';
            $html .= '<td>' . $meeting->start_date . '</td>';
            $html .= '<td>' . $meeting->start_time . '</td>';
            $html .= '<td>' . $meeting->end_time . '</td>';
            $html .= '<td>' . ($meeting->host ? $meeting->host->name : '') . '</td>';
            $html .= '<td>' . ($meeting->coHost ? $meeting->coHost->name : 'New') . '</td>';
            $html .= '<td>' . $meeting->booking_type . '</td>';
            $html .= '<td>' . $meeting->booking_status . '</td>';
            $html .= '<td>' . $meeting->description . '</td>';
            $html .= '<td>' . $participants . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table></body></html>';


         // Set paper size and margins
        $pdf = Pdf::loadHTML($html)
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 96,
            'defaultFont' => 'sans-serif',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
        ]);
        return $pdf->download('employees-pdf-export.pdf');

    }  


    public function exportMeetingCsv()
    {
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;

        $meetingsQuery = Meeting::with(['room', 'host', 'coHost', 'participants.employee'])
            ->select(
                'id', 
                'room_id', 
                'meeting_title', 
                'start_date', 
                'start_time', 
                'end_time', 
                'host_id', 
                'co_host_id', 
                'booking_type', 
                'booking_status', 
                'description'
            );

        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();


        $csvHeader = [
            'Meeting ID', 
            'Room Name', 
            'Title', 
            'Date', 
            'Start Time', 
            'End Time', 
            'Host', 
            'Co-Host', 
            'Type', 
            'Status', 
            'Description', 
            'Participants'
        ];
        
        $csvData = [];

        foreach ($meetings as $meeting) {
            $participants = $meeting->participants->map(function ($participant) {
                return $participant->employee ? 
                    "{$participant->employee->name} (Division: {$participant->employee->division}, Designation: {$participant->employee->designation})" 
                    : '';
            })->implode(', ');

            $csvData[] = [
                $meeting->id,
                $meeting->room ? $meeting->room->name : 'N/A',
                $meeting->meeting_title,
                $meeting->start_date,
                $meeting->start_time,
                $meeting->end_time,
                $meeting->host ? $meeting->host->name : '',
                $meeting->coHost ? $meeting->coHost->name : 'New',
                $meeting->booking_type,
                $meeting->booking_status,
                $meeting->description,
                $participants
            ];
        }

        $filename = 'meetings-csv-export.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }




    public function printView()
    {
        // Retrieve the authenticated user's employee ID and role ID
        $employeeId = Auth()->user()->employee_id;
        $roleId = Auth()->user()->role_id;

        // Fetch meetings based on user role
        $meetingsQuery = Meeting::with(['room', 'host', 'coHost', 'participants.employee'])
            ->select(
                'id', 
                'room_id', 
                'meeting_title', 
                'start_date', 
                'start_time', 
                'end_time', 
                'host_id', 
                'co_host_id', 
                'booking_type', 
                'booking_status', 
                'description'
            );

        if ($roleId !== 1) {
            $meetingsQuery->where(function ($query) use ($employeeId) {
                $query->where('host_id', $employeeId)
                    ->orWhereHas('participants', function ($query) use ($employeeId) {
                        $query->where('participant_id', $employeeId);
                    });
            });
        }

        $meetings = $meetingsQuery->get();

        return view('admin.meeting.print', compact('meetings'));
    }


}



